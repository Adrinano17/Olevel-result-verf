<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostUtmeResultRequest;
use App\Models\PostUtmeResult;
use App\Models\JambResult;
use App\Models\Course;
use App\Services\AuditLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostUtmeController extends Controller
{
    protected $auditLogService;

    public function __construct(AuditLogService $auditLogService)
    {
        $this->auditLogService = $auditLogService;
    }

    /**
     * Show Post-UTME result submission form
     */
    public function index()
    {
        $jambResults = JambResult::where('user_id', Auth::id())
            ->with(['firstChoiceCourse', 'secondChoiceCourse', 'thirdChoiceCourse'])
            ->orderBy('created_at', 'desc')
            ->get();

        $postUtmeResults = PostUtmeResult::where('user_id', Auth::id())
            ->with(['jambResult', 'course'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('postutme.index', compact('jambResults', 'postUtmeResults'));
    }

    /**
     * Submit Post-UTME result
     */
    public function submit(PostUtmeResultRequest $request)
    {
        try {
            // Verify JAMB result belongs to user
            $jambResult = JambResult::where('id', $request->jamb_result_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Verify course is in JAMB choices
            $courseInChoices = in_array($request->course_id, [
                $jambResult->first_choice_course_id,
                $jambResult->second_choice_course_id,
                $jambResult->third_choice_course_id,
            ]);

            if (!$courseInChoices) {
                return back()
                    ->with('error', 'Selected course must be one of your JAMB course choices.')
                    ->withInput();
            }

            $postUtmeResult = PostUtmeResult::create([
                'user_id' => Auth::id(),
                'jamb_result_id' => $request->jamb_result_id,
                'post_utme_reg_number' => strtoupper(trim($request->post_utme_reg_number)),
                'post_utme_score' => $request->post_utme_score,
                'exam_year' => $request->exam_year,
                'course_id' => $request->course_id,
                'verified_at' => now(),
                'ip_address' => $request->ip(),
            ]);

            // Log audit trail
            $this->auditLogService->log(
                'post_utme_result_submitted',
                PostUtmeResult::class,
                $postUtmeResult->id,
                'Post-UTME result submitted',
                $request->all()
            );

            return redirect()
                ->route('postutme.result', $postUtmeResult->id)
                ->with('success', 'Post-UTME result submitted successfully!');

        } catch (\Exception $e) {
            \Log::error('Post-UTME Result Submission Error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            return back()
                ->with('error', 'An error occurred while submitting Post-UTME result. Please try again.')
                ->withInput();
        }
    }

    /**
     * Show Post-UTME result
     */
    public function result($id)
    {
        $postUtmeResult = PostUtmeResult::with([
            'jambResult',
            'course.faculty'
        ])->findOrFail($id);

        // Check authorization
        if (!Auth::user()->isAdmin() && $postUtmeResult->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('postutme.result', compact('postUtmeResult'));
    }
}






