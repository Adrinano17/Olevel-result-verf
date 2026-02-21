<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdmissionValidationRequest;
use App\Models\AdmissionValidation;
use App\Models\JambResult;
use App\Models\VerificationRequest;
use App\Models\Course;
use App\Services\AdmissionValidationService;
use App\Services\AuditLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdmissionController extends Controller
{
    protected $admissionValidationService;
    protected $auditLogService;

    public function __construct(
        AdmissionValidationService $admissionValidationService,
        AuditLogService $auditLogService
    ) {
        $this->admissionValidationService = $admissionValidationService;
        $this->auditLogService = $auditLogService;
    }

    /**
     * Show admission validation form
     */
    public function index()
    {
        $jambResults = JambResult::where('user_id', Auth::id())
            ->with(['firstChoiceCourse', 'secondChoiceCourse', 'thirdChoiceCourse'])
            ->orderBy('created_at', 'desc')
            ->get();

        $olevelVerifications = VerificationRequest::where('user_id', Auth::id())
            ->where('status', 'success')
            ->with('verificationResult')
            ->orderBy('created_at', 'desc')
            ->get();

        $courses = Course::where('is_active', true)
            ->with('faculty')
            ->orderBy('faculty_id')
            ->orderBy('name')
            ->get();

        $validations = AdmissionValidation::where('user_id', Auth::id())
            ->with(['jambResult', 'course', 'olevelVerification'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admission.index', compact('jambResults', 'olevelVerifications', 'courses', 'validations'));
    }

    /**
     * Perform admission validation
     */
    public function store(AdmissionValidationRequest $request)
    {
        try {
            // Verify JAMB result belongs to user
            $jambResult = JambResult::where('id', $request->jamb_result_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Verify O-Level verification belongs to user
            $olevelVerification = VerificationRequest::where('id', $request->olevel_verification_id)
                ->where('user_id', Auth::id())
                ->where('status', 'success')
                ->firstOrFail();

            // Perform validation
            $validation = $this->admissionValidationService->validateAdmission(
                Auth::id(),
                $request->jamb_result_id,
                $request->olevel_verification_id,
                null, // Post-UTME removed
                $request->course_id
            );

            // Log audit trail
            $this->auditLogService->log(
                'admission_validation',
                AdmissionValidation::class,
                $validation->id,
                'Admission validation performed',
                $request->all(),
                [
                    'status' => $validation->validation_status,
                    'eligible' => $validation->overall_eligible,
                ]
            );

            return redirect()
                ->route('admission.result', $validation->id)
                ->with('success', 'Admission validation completed!');

        } catch (\Exception $e) {
            \Log::error('Admission Validation Error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            return back()
                ->with('error', 'An error occurred during validation: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show admission validation result
     */
    public function result($id)
    {
        $validation = AdmissionValidation::with([
            'jambResult.firstChoiceCourse',
            'jambResult.secondChoiceCourse',
            'jambResult.thirdChoiceCourse',
            'postUtmeResult',
            'olevelVerification.verificationResult',
            'course.faculty',
            'course.requirements',
            'course.jambSubjects',
            'course.olevelSubjects',
        ])->findOrFail($id);

        // Check authorization
        if (!Auth::user()->isAdmin() && $validation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('admission.result', compact('validation'));
    }

    /**
     * Get validation history
     */
    public function history()
    {
        $validations = AdmissionValidation::where('user_id', Auth::id())
            ->with(['jambResult', 'course', 'olevelVerification'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admission.history', compact('validations'));
    }
}

