<?php

namespace App\Http\Services\web;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JobApplicationService
{
    /**
     * Apply for a job.
     *
     * @param User $user
     * @param Job $job
     * @param array $data
     * @return JobApplication
     * @throws \Exception
     */
    public function apply(User $user, Job $job, array $data): JobApplication
    {
        // Basic checks
        if (!$user->isCandidate()) {
            throw new \Exception('Only candidates can apply for jobs.');
        }

        if ($job->status !== 'Published') {
            throw new \Exception('This job is no longer accepting applications.');
        }

        // Check if already applied
        if ($this->hasAlreadyApplied($user, $job)) {
            throw new \Exception('You have already applied for this position.');
        }

        try {
            return DB::transaction(function () use ($user, $job, $data) {
                // Use default resume from profile if not provided in $data
                $resumePath = $data['resume_path'] ?? ($user->candidateProfile->resume ?? null);

                return JobApplication::create([
                    'job_id' => $job->id,
                    'user_id' => $user->id,
                    'cover_letter' => $data['cover_letter'] ?? null,
                    'resume_path' => $resumePath,
                    'status' => 'Pending',
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Error applying for job: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'job_id' => $job->id,
                'data' => $data,
            ]);
            throw $e;
        }
    }

    /**
     * Get applications for a specific candidate.
     *
     * @param User $user
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getCandidateApplications(User $user, int $perPage = 10)
    {
        return $user->applications()
            ->with(['job.user'])
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Withdraw a job application.
     *
     * @param JobApplication $application
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function withdraw(JobApplication $application, User $user): bool
    {
        if ($application->user_id !== $user->id) {
            throw new \Exception('Unauthorized action.');
        }

        // Only allow withdrawing if still pending or reviewed
        if (!in_array($application->status, ['Pending', 'Reviewed'])) {
            throw new \Exception('Cannot withdraw application at this stage.');
        }

        return $application->delete();
    }

    /**
     * Check if a user has already applied for a job.
     *
     * @param User $user
     * @param Job $job
     * @return bool
     */
    public function hasAlreadyApplied(User $user, Job $job): bool
    {
        return JobApplication::where('user_id', $user->id)
            ->where('job_id', $job->id)
            ->exists();
    }
}
