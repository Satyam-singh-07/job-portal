<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Services\web\JobApplicationService;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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

        return view('candidates.applications', [
            'applications' => $applications,
            'applicationBalance' => (int) ($user->job_application_balance ?? 0),
        ]);
    }

    /**
     * Store a newly created job application.
     */
    public function store(Request $request, Job $job)
    {
        $request->validate([
            'cover_letter' => 'nullable|string|max:5000',
        ]);

        try {
            $user = Auth::user();

            $this->applicationService->apply($user, $job, $request->only('cover_letter'));

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Application submitted successfully! You can track it in your dashboard.',
                ]);
            }

            return back()->with('success', 'Application submitted successfully!');
        } catch (ValidationException $e) {
            $message = collect($e->errors())->flatten()->first() ?: 'Unable to submit application.';

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'errors' => $e->errors(),
                    'redirect' => str_contains(strtolower($message), 'upload a resume')
                        ? route('candidate.edit-profile')
                        : null,
                ], 422);
            }

            return back()->with('error', $message);
        } catch (\Throwable $e) {
            report($e);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to submit application right now. Please try again.'
                ], 500);
            }

            return back()->with('error', 'Unable to submit application right now. Please try again.');
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
