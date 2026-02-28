<?php

namespace App\Http\Services\Employer;

use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JobService
{
    /**
     * Store a newly created job in the database.
     *
     * @param User $user
     * @param array $data
     * @return Job
     * @throws \Exception
     */
    public function storeJob(User $user, array $data): Job
    {
        try {
            return DB::transaction(function () use ($user, $data) {
                // Ensure boolean fields are set
                $data['visa_sponsorship'] = isset($data['visa_sponsorship']) ? (bool) $data['visa_sponsorship'] : false;
                $data['allow_quick_apply'] = isset($data['allow_quick_apply']) ? (bool) $data['allow_quick_apply'] : false;

                // Set default status if not provided
                $data['status'] = $data['status'] ?? 'Published';

                return $user->jobs()->create($data);
            });
        } catch (\Exception $e) {
            Log::error('Error storing job: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Update an existing job.
     *
     * @param Job $job
     * @param array $data
     * @return Job
     * @throws \Exception
     */
    public function updateJob(Job $job, array $data): Job
    {
        try {
            return DB::transaction(function () use ($job, $data) {
                // Ensure boolean fields are set (since checkboxes might not be in the request)
                $data['visa_sponsorship'] = isset($data['visa_sponsorship']) ? (bool) $data['visa_sponsorship'] : false;
                $data['allow_quick_apply'] = isset($data['allow_quick_apply']) ? (bool) $data['allow_quick_apply'] : false;

                $job->update($data);
                return $job;
            });
        } catch (\Exception $e) {
            Log::error('Error updating job: ' . $e->getMessage(), [
                'job_id' => $job->id,
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Get paginated jobs for an employer with counts.
     *
     * @param User $user
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getEmployerJobs(User $user, int $perPage = 10)
    {
        return $user->jobs()
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get job statistics for an employer.
     *
     * @param User $user
     * @return array
     */
    public function getEmployerStats(User $user): array
    {
        $stats = $user->jobs()
            ->selectRaw('
                count(*) as total,
                count(case when status = "Published" then 1 end) as active,
                count(case when status = "Draft" then 1 end) as draft,
                count(case when status = "Closed" then 1 end) as closed
            ')
            ->first();

        return [
            'total' => $stats->total ?? 0,
            'active' => $stats->active ?? 0,
            'draft' => $stats->draft ?? 0,
            'closed' => $stats->closed ?? 0,
            'total_applications' => 0, // Placeholder for when applications table exists
            'pending_reviews' => 0,    // Placeholder
        ];
    }

    /**
     * Update job status.
     *
     * @param Job $job
     * @param string $status
     * @return bool
     */
    public function updateStatus(Job $job, string $status): bool
    {
        return $job->update(['status' => $status]);
    }

    /**
     * Delete a job.
     *
     * @param Job $job
     * @return bool
     */
    public function deleteJob(Job $job): bool
    {
        return $job->delete();
    }
}
