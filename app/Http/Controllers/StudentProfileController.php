<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentProfileRequest;
use App\Models\StudentProfile;
use App\Models\User;
use App\Services\AuditLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentProfileController extends Controller
{
    protected $auditLogService;

    public function __construct(AuditLogService $auditLogService)
    {
        $this->auditLogService = $auditLogService;
    }

    /**
     * Show user's own profile or form to create one
     */
    public function index()
    {
        $profile = Auth::user()->studentProfile;
        
        if (!$profile) {
            return redirect()->route('student-profile.create');
        }

        return view('student-profile.show', compact('profile'));
    }

    /**
     * Show the form for creating a new profile
     */
    public function create()
    {
        // Check if profile already exists
        if (Auth::user()->studentProfile) {
            return redirect()->route('student-profile.index')
                ->with('info', 'You already have a profile. You can edit it instead.');
        }

        return view('student-profile.create');
    }

    /**
     * Store a newly created profile
     */
    public function store(StudentProfileRequest $request)
    {
        try {
            $profile = StudentProfile::create([
                'user_id' => Auth::id(),
                ...$request->validated()
            ]);

            // Log audit trail
            $this->auditLogService->log(
                'student_profile_created',
                StudentProfile::class,
                $profile->id,
                'Student profile created',
                $request->all()
            );

            return redirect()
                ->route('student-profile.index')
                ->with('success', 'Profile created successfully!');
        } catch (\Exception $e) {
            \Log::error('Student Profile Creation Error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            return back()
                ->with('error', 'An error occurred while creating your profile. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display the specified profile
     */
    public function show($id)
    {
        $profile = StudentProfile::with('user')->findOrFail($id);

        // Check authorization: users can only view their own profile unless admin
        if (!Auth::user()->isAdmin() && $profile->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('student-profile.show', compact('profile'));
    }

    /**
     * Show the form for editing the profile
     */
    public function edit($id)
    {
        $profile = StudentProfile::findOrFail($id);

        // Check authorization
        if (!Auth::user()->isAdmin() && $profile->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('student-profile.edit', compact('profile'));
    }

    /**
     * Update the profile
     */
    public function update(StudentProfileRequest $request, $id)
    {
        try {
            $profile = StudentProfile::findOrFail($id);

            // Check authorization
            if (!Auth::user()->isAdmin() && $profile->user_id !== Auth::id()) {
                abort(403, 'Unauthorized access.');
            }

            $profile->update($request->validated());

            // Log audit trail
            $this->auditLogService->log(
                'student_profile_updated',
                StudentProfile::class,
                $profile->id,
                'Student profile updated',
                $request->all()
            );

            return redirect()
                ->route('student-profile.index')
                ->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Student Profile Update Error', [
                'profile_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->with('error', 'An error occurred while updating your profile. Please try again.')
                ->withInput();
        }
    }

    /**
     * Admin: List all student profiles
     */
    public function adminIndex()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $profiles = StudentProfile::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('student-profile.admin-index', compact('profiles'));
    }
}
