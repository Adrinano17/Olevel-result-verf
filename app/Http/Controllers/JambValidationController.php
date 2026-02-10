<?php

namespace App\Http\Controllers;

use App\Http\Requests\JambResultRequest;
use App\Models\JambResult;
use App\Models\Course;
use App\Services\AuditLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JambValidationController extends Controller
{
    protected $auditLogService;

    public function __construct(AuditLogService $auditLogService)
    {
        $this->auditLogService = $auditLogService;
    }

    /**
     * Show JAMB result submission form
     */
    public function index()
    {
        $courses = Course::where('is_active', true)
            ->with('faculty')
            ->orderBy('faculty_id')
            ->orderBy('name')
            ->get();

        $jambResults = JambResult::where('user_id', Auth::id())
            ->with(['firstChoiceCourse', 'secondChoiceCourse', 'thirdChoiceCourse'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('jamb.index', compact('courses', 'jambResults'));
    }

    /**
     * Submit JAMB result
     */
    public function submit(JambResultRequest $request)
    {
        try {
            $jambResult = JambResult::create([
                'user_id' => Auth::id(),
                'jamb_reg_number' => strtoupper(trim($request->jamb_reg_number)),
                'jamb_score' => $request->jamb_score,
                'exam_year' => $request->exam_year,
                'subjects' => $request->subjects,
                'first_choice_course_id' => $request->first_choice_course_id,
                'second_choice_course_id' => $request->second_choice_course_id,
                'third_choice_course_id' => $request->third_choice_course_id,
                'verified_at' => now(),
                'ip_address' => $request->ip(),
            ]);

            // Log audit trail
            $this->auditLogService->log(
                'jamb_result_submitted',
                JambResult::class,
                $jambResult->id,
                'JAMB result submitted',
                $request->all()
            );

            return redirect()
                ->route('jamb.result', $jambResult->id)
                ->with('success', 'JAMB result submitted successfully!');

        } catch (\Exception $e) {
            \Log::error('JAMB Result Submission Error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            return back()
                ->with('error', 'An error occurred while submitting JAMB result. Please try again.')
                ->withInput();
        }
    }

    /**
     * Show JAMB result
     */
    public function result($id)
    {
        $jambResult = JambResult::with([
            'firstChoiceCourse.faculty',
            'secondChoiceCourse.faculty',
            'thirdChoiceCourse.faculty'
        ])->findOrFail($id);

        // Check authorization
        if (!Auth::user()->isAdmin() && $jambResult->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('jamb.result', compact('jambResult'));
    }
}



