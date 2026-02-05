<?php

namespace App\Http\Controllers;

use App\Models\VerificationRequest;
use App\Models\VerificationResult;
use App\Services\ExaminationApiService;
use App\Services\AuditLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VerificationController extends Controller
{
    protected $examinationApiService;
    protected $auditLogService;

    public function __construct(
        ExaminationApiService $examinationApiService,
        AuditLogService $auditLogService
    ) {
        $this->examinationApiService = $examinationApiService;
        $this->auditLogService = $auditLogService;
    }

    /**
     * Show verification form
     */
    public function index()
    {
        return view('verification.index');
    }

    /**
     * Verify result
     */
    public function verify(Request $request)
    {
        // Increase execution time for API calls
        set_time_limit(90); // 90 seconds max
        
        // Validate input
        $validator = Validator::make($request->all(), [
            'exam_number' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Z0-9\/\-]+$/i', // Alphanumeric, slashes, and hyphens
            ],
            'exam_year' => [
                'required',
                'integer',
                'min:2000',
                'max:' . (date('Y') + 1),
            ],
            'exam_body' => [
                'required',
                Rule::in(['WAEC', 'NECO']),
            ],
            'result_type' => [
                'required',
                'string',
                'max:50',
                Rule::in(['SSCE', 'GCE', 'MAY/JUN', 'NOV/DEC']),
            ],
        ], [
            'exam_number.required' => 'Exam number is required.',
            'exam_number.regex' => 'Exam number contains invalid characters.',
            'exam_year.required' => 'Exam year is required.',
            'exam_year.min' => 'Exam year must be 2000 or later.',
            'exam_year.max' => 'Exam year cannot be in the future.',
            'exam_body.required' => 'Exam body is required.',
            'exam_body.in' => 'Exam body must be WAEC or NECO.',
            'result_type.required' => 'Result type is required.',
            'result_type.in' => 'Invalid result type.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create verification request
        $verificationRequest = VerificationRequest::create([
            'user_id' => Auth::id(),
            'exam_number' => strtoupper(trim($request->exam_number)),
            'exam_year' => $request->exam_year,
            'exam_body' => $request->exam_body,
            'result_type' => $request->result_type,
            'status' => 'pending',
            'ip_address' => $request->ip(),
        ]);

        // Call appropriate API
        try {
            if ($request->exam_body === 'WAEC') {
                $apiResponse = $this->examinationApiService->verifyWaec(
                    $verificationRequest->exam_number,
                    $verificationRequest->exam_year,
                    $verificationRequest->result_type
                );
            } else {
                $apiResponse = $this->examinationApiService->verifyNeco(
                    $verificationRequest->exam_number,
                    $verificationRequest->exam_year,
                    $verificationRequest->result_type
                );
            }

            // Determine status
            $status = 'failed';
            if ($apiResponse['success']) {
                $status = 'success';
            } elseif ($apiResponse['code'] === 'TIMEOUT') {
                $status = 'timeout';
            }

            // Update request status
            $verificationRequest->update(['status' => $status]);

            // Create verification result
            $verificationResult = VerificationResult::create([
                'verification_request_id' => $verificationRequest->id,
                'candidate_name' => $apiResponse['data']['candidate_name'] ?? null,
                'response_code' => $apiResponse['code'],
                'response_message' => $apiResponse['message'],
                'subjects' => $apiResponse['data']['subjects'] ?? null,
                'raw_response' => $apiResponse,
                'verified_at' => now(),
            ]);

            // Log audit trail
            $this->auditLogService->logVerificationRequest(
                $verificationRequest->id,
                $request->all(),
                $apiResponse
            );

            // Return response
            if ($apiResponse['success']) {
                return redirect()
                    ->route('verification.result', $verificationRequest->id)
                    ->with('success', 'Result verified successfully!');
            } else {
                return redirect()
                    ->route('verification.result', $verificationRequest->id)
                    ->with('error', $apiResponse['message']);
            }

        } catch (\Exception $e) {
            // Update request status
            $verificationRequest->update(['status' => 'failed']);

            // Log error
            \Log::error('Verification Error', [
                'request_id' => $verificationRequest->id,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->with('error', 'An error occurred while verifying the result. Please try again.')
                ->withInput();
        }
    }

    /**
     * Show verification result
     */
    public function result($id)
    {
        $verificationRequest = VerificationRequest::with('verificationResult')
            ->findOrFail($id);

        // Check authorization (users can only view their own requests unless admin)
        if (!Auth::user()->isAdmin() && $verificationRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('verification.result', compact('verificationRequest'));
    }

    /**
     * Get verification history
     */
    public function history()
    {
        $requests = VerificationRequest::with('verificationResult')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('verification.history', compact('requests'));
    }
}


