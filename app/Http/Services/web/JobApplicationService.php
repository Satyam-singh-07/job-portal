<?php

namespace App\Http\Services\web;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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
        if (! $user->isCandidate()) {
            throw ValidationException::withMessages([
                'application' => ['Only candidates can apply for jobs.'],
            ]);
        }

        if ($job->status !== 'Published') {
            throw ValidationException::withMessages([
                'application' => ['This job is no longer accepting applications.'],
            ]);
        }

        if (! $user->candidateProfile || ! $user->candidateProfile->resume) {
            throw ValidationException::withMessages([
                'application' => ['Please complete your profile and upload a resume before applying.'],
            ]);
        }

        try {
            return DB::transaction(function () use ($user, $job, $data) {
                $resumePath = $data['resume_path'] ?? ($user->candidateProfile->resume ?? null);

                $existingApplication = JobApplication::withTrashed()
                    ->where('user_id', $user->id)
                    ->where('job_id', $job->id)
                    ->first();

                if ($existingApplication && ! $existingApplication->trashed()) {
                    throw ValidationException::withMessages([
                        'application' => ['You have already applied for this position.'],
                    ]);
                }

                if ($existingApplication && $existingApplication->trashed()) {
                    $existingApplication->restore();
                    $existingApplication->update([
                        'cover_letter' => $data['cover_letter'] ?? null,
                        'resume_path' => $resumePath,
                        'status' => 'Pending',
                    ]);

                    return $existingApplication->fresh();
                }

                return JobApplication::create([
                    'job_id' => $job->id,
                    'user_id' => $user->id,
                    'cover_letter' => $data['cover_letter'] ?? null,
                    'resume_path' => $resumePath,
                    'status' => 'Pending',
                ]);
            });
        } catch (ValidationException $e) {
            throw $e;
        } catch (QueryException $e) {
            if ($this->isDuplicateApplicationError($e)) {
                throw ValidationException::withMessages([
                    'application' => ['You have already applied for this position.'],
                ]);
            }

            Log::error('Database error while applying for job.', [
                'user_id' => $user->id,
                'job_id' => $job->id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
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

    protected function isDuplicateApplicationError(QueryException $e): bool
    {
        $errorInfo = $e->errorInfo;

        if (! is_array($errorInfo)) {
            return false;
        }

        $sqlState = $errorInfo[0] ?? null;
        $driverCode = $errorInfo[1] ?? null;
        $message = (string) ($errorInfo[2] ?? '');

        return $sqlState === '23000'
            && (int) $driverCode === 1062
            && str_contains($message, 'job_applications_job_id_user_id_unique');
    }
}
