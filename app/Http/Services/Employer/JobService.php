<?php

namespace App\Http\Services\Employer;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobView;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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
                $shouldConsumePostingCredit = $data['status'] === 'Published';

                if ($shouldConsumePostingCredit) {
                    $this->consumeEmployerPostingCredit((int) $user->id);
                }

                $data['posting_credit_consumed'] = $shouldConsumePostingCredit;

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

                $publishingFirstTime = ($data['status'] ?? $job->status) === 'Published' && ! (bool) $job->posting_credit_consumed;
                if ($publishingFirstTime) {
                    $this->consumeEmployerPostingCredit((int) $job->user_id);
                    $data['posting_credit_consumed'] = true;
                }

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
            ->withCount([
                'applications',
                'jobViews as views_count',
            ])
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

        $totalApplications = JobApplication::whereHas('job', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        $pendingReviews = JobApplication::where('status', 'Pending')
            ->whereHas('job', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count();

        $totalViews = JobView::whereHas('job', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        return [
            'total' => $stats->total ?? 0,
            'active' => $stats->active ?? 0,
            'draft' => $stats->draft ?? 0,
            'closed' => $stats->closed ?? 0,
            'total_applications' => $totalApplications,
            'pending_reviews' => $pendingReviews,
            'total_views' => $totalViews,
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
        return DB::transaction(function () use ($job, $status): bool {
            if ($status === 'Published' && ! (bool) $job->posting_credit_consumed) {
                $this->consumeEmployerPostingCredit((int) $job->user_id);
            }

            return $job->update([
                'status' => $status,
                'posting_credit_consumed' => (bool) $job->posting_credit_consumed || $status === 'Published',
            ]);
        });
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

    protected function consumeEmployerPostingCredit(int $userId): void
    {
        $affected = User::query()
            ->whereKey($userId)
            ->where('job_posting_balance', '>', 0)
            ->decrement('job_posting_balance');

        if ($affected === 0) {
            throw ValidationException::withMessages([
                'balance' => ['No job posting balance left. Ask admin to add more posting credits.'],
            ]);
        }
    }
}
