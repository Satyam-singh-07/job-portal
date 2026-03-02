<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use App\Notifications\ApplicationStatusUpdatedNotification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobApplicationController extends Controller
{
    protected array $allowedStatuses = [
        'Pending',
        'Reviewed',
        'Interviewing',
        'Offered',
        'Rejected',
        'Accepted',
    ];

    public function index(Job $job, Request $request)
    {
        $this->authorizeOwner($job);

        $status = $request->string('status')->toString();
        $search = trim((string) $request->input('search'));

        $applicationsQuery = $job->applications()
            ->with(['user.candidateProfile'])
            ->latest();

        if ($status !== '' && in_array($status, $this->allowedStatuses, true)) {
            $applicationsQuery->where('status', $status);
        }

        if ($search !== '') {
            $applicationsQuery->whereHas('user', function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            });
        }

        $applications = $applicationsQuery->paginate(12)->withQueryString();

        $statusStats = $job->applications()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('employer.job-applications', [
            'job' => $job,
            'applications' => $applications,
            'statusFilter' => $status,
            'search' => $search,
            'allowedStatuses' => $this->allowedStatuses,
            'statusStats' => $statusStats,
            'totalApplications' => (int) $job->applications()->count(),
        ]);
    }

    public function updateStatus(Job $job, JobApplication $application, Request $request)
    {
        $this->authorizeOwner($job);

        if ($application->job_id !== $job->id) {
            abort(404);
        }

        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in($this->allowedStatuses)],
        ]);

        $oldStatus = (string) $application->status;
        $newStatus = (string) $validated['status'];

        if ($oldStatus === $newStatus) {
            return response()->json([
                'success' => true,
                'message' => 'Application status is already up to date.',
                'status' => $application->status,
            ]);
        }

        $application->update([
            'status' => $newStatus,
        ]);

        $application->loadMissing(['job', 'user']);

        if ($application->user) {
            $application->user->notify(new ApplicationStatusUpdatedNotification(
                $application,
                $oldStatus,
                $newStatus,
            ));
        }

        return response()->json([
            'success' => true,
            'message' => 'Application status updated successfully.',
            'status' => $application->status,
        ]);
    }

    protected function authorizeOwner(Job $job): void
    {
        if ($job->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
