<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Services\web\JobApplicationService;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    protected $applicationService;

    public function __construct(JobApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    /**
     * Display a listing of the candidate's applications.
     */
    public function index()
    {
        $user = Auth::user();
        $applications = $this->applicationService->getCandidateApplications($user);

        return view('candidates.applications', compact('applications'));
    }

    /**
     * Store a newly created job application.
     */
    public function store(Request $request, Job $job)
    {
        // Simple validation for enterprise level
        $request->validate([
            'cover_letter' => 'nullable|string|max:5000',
        ]);

        try {
            $user = Auth::user();
            
            // Check if profile exists and has a resume
            if (!$user->candidateProfile || !$user->candidateProfile->resume) {
                $message = 'Please complete your profile and upload a resume before applying.';
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $message,
                        'redirect' => route('candidate.edit-profile')
                    ], 422);
                }
                return redirect()->route('candidate.edit-profile')->with('error', $message);
            }

            $this->applicationService->apply($user, $job, $request->only('cover_letter'));

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Application submitted successfully! You can track it in your dashboard.',
                ]);
            }

            return back()->with('success', 'Application submitted successfully!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove (withdraw) the specified application.
     */
    public function destroy(JobApplication $application)
    {
        try {
            $this->applicationService->withdraw($application, Auth::user());

            return response()->json([
                'success' => true,
                'message' => 'Application withdrawn successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
