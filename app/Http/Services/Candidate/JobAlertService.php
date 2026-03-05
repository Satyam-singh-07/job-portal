<?php

namespace App\Http\Services\Candidate;

use App\Models\JobAlert;
use App\Models\User;

class JobAlertService
{
    public function getForUser(User $user, string $status = 'all', int $perPage = 10)
    {
        return JobAlert::query()
            ->select([
                'id',
                'user_id',
                'role_keywords',
                'locations',
                'job_type',
                'frequency',
                'min_salary',
                'delivery_channel',
                'notes',
                'is_active',
                'updated_at',
                'created_at',
            ])
            ->where('user_id', $user->id)
            ->when($status === 'active', fn ($query) => $query->where('is_active', true))
            ->when($status === 'paused', fn ($query) => $query->where('is_active', false))
            ->latest('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(User $user, array $payload): JobAlert
    {
        return JobAlert::create([
            'user_id' => $user->id,
            'role_keywords' => $payload['role_keywords'],
            'locations' => $payload['locations'] ?? null,
            'job_type' => $payload['job_type'],
            'frequency' => $payload['frequency'],
            'min_salary' => $payload['min_salary'] ?? null,
            'delivery_channel' => $payload['delivery_channel'],
            'notes' => $payload['notes'] ?? null,
            'is_active' => true,
        ]);
    }

    public function findOwnedAlertOrFail(User $user, int $alertId): JobAlert
    {
        return JobAlert::query()
            ->where('user_id', $user->id)
            ->findOrFail($alertId);
    }

    public function updateStatus(JobAlert $alert, bool $isActive): bool
    {
        return $alert->update(['is_active' => $isActive]);
    }

    public function pauseAll(User $user): int
    {
        return JobAlert::query()
            ->where('user_id', $user->id)
            ->where('is_active', true)
            ->update(['is_active' => false]);
    }

    public function delete(JobAlert $alert): bool
    {
        return (bool) $alert->delete();
    }

    public function getStats(User $user): array
    {
        $stats = JobAlert::query()
            ->where('user_id', $user->id)
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active')
            ->selectRaw('SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END) as paused')
            ->first();

        return [
            'total' => (int) ($stats?->total ?? 0),
            'active' => (int) ($stats?->active ?? 0),
            'paused' => (int) ($stats?->paused ?? 0),
        ];
    }
}
