<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\StoreJobRequest;
use App\Http\Services\Employer\JobService;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class JobController extends Controller
{
    protected $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    /**
     * Display a listing of the employer's jobs.
     */
    public function index()
    {
        $user = Auth::user();
        $jobs = $this->jobService->getEmployerJobs($user);
        $stats = $this->jobService->getEmployerStats($user);

        return view('employer.manage-job', array_merge($stats, [
            'jobs' => $jobs,
            'activeJobsCount' => $stats['active'],
            'draftJobsCount' => $stats['draft'],
        ]));
    }

    public function create()
    {
        return view('employer.post-job');
    }

    public function store(StoreJobRequest $request)
    {
        try {
            $data = $request->validated();
            
            // Set status based on the button clicked
            $data['status'] = $request->input('action') === 'draft' ? 'Draft' : 'Published';
            
            $job = $this->jobService->storeJob(Auth::user(), $data);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Job ' . ($data['status'] === 'Draft' ? 'saved as draft' : 'published') . ' successfully!',
                    'redirect' => route('employer.manage-jobs')
                ]);
            }

            return redirect()->route('employer.manage-jobs')->with('success', 'Job posted successfully!');
        } catch (ValidationException $e) {
            $message = collect($e->errors())->flatten()->first() ?: 'Validation failed.';

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'errors' => $e->errors(),
                ], 422);
            }

            return back()->with('error', $message)->withInput();
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong. Please try again.'
                ], 500);
            }
            return back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    /**
     * Show the form for editing the specified job.
     */
    public function edit(Job $job)
    {
        $this->authorizeOwner($job);
        return view('employer.edit-job', compact('job'));
    }

    /**
     * Update the specified job in storage.
     */
    public function update(StoreJobRequest $request, Job $job)
    {
        $this->authorizeOwner($job);

        try {
            $data = $request->validated();
            
            // Optional: If you want to allow changing status during edit
            if ($request->has('action')) {
                $data['status'] = $request->input('action') === 'draft' ? 'Draft' : 'Published';
            }

            $this->jobService->updateJob($job, $data);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Job updated successfully!',
                    'redirect' => route('employer.manage-jobs')
                ]);
            }

            return redirect()->route('employer.manage-jobs')->with('success', 'Job updated successfully!');
        } catch (ValidationException $e) {
            $message = collect($e->errors())->flatten()->first() ?: 'Validation failed.';

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'errors' => $e->errors(),
                ], 422);
            }

            return back()->with('error', $message)->withInput();
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong. Please try again.'
                ], 500);
            }
            return back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    /**
     * Update job status to Published.
     */
    public function publish(Job $job)
    {
        $this->authorizeOwner($job);
        try {
            $this->jobService->updateStatus($job, 'Published');
            return response()->json(['success' => true, 'message' => 'Job published successfully!']);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => collect($e->errors())->flatten()->first() ?: 'Unable to publish job.',
            ], 422);
        }
    }

    /**
     * Update job status to Closed.
     */
    public function close(Job $job)
    {
        $this->authorizeOwner($job);
        $this->jobService->updateStatus($job, 'Closed');
        return response()->json(['success' => true, 'message' => 'Job closed successfully!']);
    }

    /**
     * Update job status to Published (reopen).
     */
    public function reopen(Job $job)
    {
        $this->authorizeOwner($job);
        try {
            $this->jobService->updateStatus($job, 'Published');
            return response()->json(['success' => true, 'message' => 'Job reopened successfully!']);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => collect($e->errors())->flatten()->first() ?: 'Unable to reopen job.',
            ], 422);
        }
    }

    /**
     * Delete the job.
     */
    public function destroy(Job $job)
    {
        $this->authorizeOwner($job);
        $this->jobService->deleteJob($job);
        return response()->json(['success' => true, 'message' => 'Job deleted successfully!']);
    }

    /**
     * Helper to authorize job owner.
     */
    protected function authorizeOwner(Job $job)
    {
        if ($job->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
