<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CandidateProfile;
use App\Models\JobApplication;
use App\Models\Role;
use App\Models\User;
use App\Models\UserPageActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CandidateController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:200'],
            'status' => ['nullable', 'in:Active,Suspended'],
            'experience_level' => ['nullable', 'string', 'max:120'],
            'work_preference' => ['nullable', 'string', 'max:120'],
            'open_to_work' => ['nullable', 'in:yes,no'],
            'sort' => ['nullable', 'in:latest,oldest,name_asc,name_desc,applications_desc,last_active_desc'],
        ]);

        $candidateRoleId = (int) Role::query()->where('name', 'candidate')->value('id');

        $query = User::query()
            ->where('role_id', $candidateRoleId)
            ->with([
                'candidateProfile:id,user_id,title,location,experience_level,work_preference,skills,is_searchable,is_public_link_active,resume',
            ])
            ->withCount(['applications', 'favoriteJobs', 'followingEmployers'])
            ->addSelect([
                'last_seen_at' => UserPageActivity::query()
                    ->selectRaw('MAX(last_seen_at)')
                    ->whereColumn('user_id', 'users.id'),
            ]);

        if (!empty($validated['search'])) {
            $search = trim($validated['search']);
            $query->where(function ($inner) use ($search): void {
                $inner->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhereHas('candidateProfile', function ($profileQuery) use ($search): void {
                        $profileQuery->where('title', 'like', "%{$search}%")
                            ->orWhere('location', 'like', "%{$search}%")
                            ->orWhere('skills', 'like', "%{$search}%");
                    });
            });
        }

        if (!empty($validated['status'])) {
            $query->where('account_status', $validated['status']);
        }

        if (!empty($validated['experience_level'])) {
            $query->whereHas('candidateProfile', function ($profileQuery) use ($validated): void {
                $profileQuery->where('experience_level', $validated['experience_level']);
            });
        }

        if (!empty($validated['work_preference'])) {
            $query->whereHas('candidateProfile', function ($profileQuery) use ($validated): void {
                $profileQuery->where('work_preference', $validated['work_preference']);
            });
        }

        if (!empty($validated['open_to_work'])) {
            $isOpenToWork = $validated['open_to_work'] === 'yes';
            if ($isOpenToWork) {
                $query->whereHas('candidateProfile', function ($profileQuery): void {
                    $profileQuery->where('is_searchable', true);
                });
            } else {
                $query->where(function ($inner): void {
                    $inner->whereDoesntHave('candidateProfile')
                        ->orWhereHas('candidateProfile', function ($profileQuery): void {
                            $profileQuery->where('is_searchable', false);
                        });
                });
            }
        }

        $sort = $validated['sort'] ?? 'latest';
        if ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'name_asc') {
            $query->orderBy('first_name')->orderBy('last_name')->orderBy('email');
        } elseif ($sort === 'name_desc') {
            $query->orderByDesc('first_name')->orderByDesc('last_name')->orderByDesc('email');
        } elseif ($sort === 'applications_desc') {
            $query->orderByDesc('applications_count')->latest();
        } elseif ($sort === 'last_active_desc') {
            $query->orderByDesc('last_seen_at')->latest();
        } else {
            $query->latest();
        }

        $candidates = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => User::query()->where('role_id', $candidateRoleId)->count(),
            'active' => User::query()->where('role_id', $candidateRoleId)->where('account_status', 'Active')->count(),
            'suspended' => User::query()->where('role_id', $candidateRoleId)->where('account_status', 'Suspended')->count(),
            'open_to_work' => User::query()
                ->where('role_id', $candidateRoleId)
                ->whereHas('candidateProfile', fn ($q) => $q->where('is_searchable', true))
                ->count(),
            'applications_total' => JobApplication::query()
                ->whereHas('user', fn ($q) => $q->where('role_id', $candidateRoleId))
                ->count(),
            'application_balance_total' => (int) User::query()
                ->where('role_id', $candidateRoleId)
                ->sum('job_application_balance'),
        ];

        $experienceLevels = CandidateProfile::query()
            ->join('users', 'users.id', '=', 'candidate_profiles.user_id')
            ->where('users.role_id', $candidateRoleId)
            ->whereNotNull('candidate_profiles.experience_level')
            ->where('candidate_profiles.experience_level', '!=', '')
            ->distinct()
            ->orderBy('candidate_profiles.experience_level')
            ->pluck('candidate_profiles.experience_level');

        $workPreferences = CandidateProfile::query()
            ->join('users', 'users.id', '=', 'candidate_profiles.user_id')
            ->where('users.role_id', $candidateRoleId)
            ->whereNotNull('candidate_profiles.work_preference')
            ->where('candidate_profiles.work_preference', '!=', '')
            ->distinct()
            ->orderBy('candidate_profiles.work_preference')
            ->pluck('candidate_profiles.work_preference');

        return view('admin.candidates.index', [
            'candidates' => $candidates,
            'stats' => $stats,
            'sidebarStats' => ['total_users' => User::count()],
            'experienceLevels' => $experienceLevels,
            'workPreferences' => $workPreferences,
            'filters' => [
                'search' => $validated['search'] ?? '',
                'status' => $validated['status'] ?? '',
                'experience_level' => $validated['experience_level'] ?? '',
                'work_preference' => $validated['work_preference'] ?? '',
                'open_to_work' => $validated['open_to_work'] ?? '',
                'sort' => $sort,
            ],
        ]);
    }

    public function updateStatus(Request $request, User $candidate): RedirectResponse
    {
        abort_unless($candidate->isCandidate(), 404);

        $payload = $request->validate([
            'account_status' => ['required', 'in:Active,Suspended'],
        ]);

        $candidate->update(['account_status' => $payload['account_status']]);

        return back()->with('success', 'Candidate account status updated.');
    }

    public function updateOpenToWork(Request $request, User $candidate): RedirectResponse
    {
        abort_unless($candidate->isCandidate(), 404);

        $payload = $request->validate([
            'open_to_work' => ['required', 'boolean'],
        ]);

        $candidate->candidateProfile()->updateOrCreate(
            ['user_id' => $candidate->id],
            ['is_searchable' => (bool) $payload['open_to_work']]
        );

        return back()->with('success', 'Candidate visibility updated.');
    }

    public function updateApplicationBalance(Request $request, User $candidate): RedirectResponse
    {
        abort_unless($candidate->isCandidate(), 404);

        $payload = $request->validate([
            'balance_action' => ['required', 'in:set,add,subtract'],
            'amount' => ['required', 'integer', 'min:0', 'max:100000'],
        ]);

        $amount = (int) $payload['amount'];
        $current = (int) ($candidate->job_application_balance ?? 0);

        if ($payload['balance_action'] === 'set') {
            $next = $amount;
        } elseif ($payload['balance_action'] === 'add') {
            $next = $current + $amount;
        } else {
            $next = max(0, $current - $amount);
        }

        $candidate->update(['job_application_balance' => $next]);

        return back()->with('success', 'Candidate application balance updated.');
    }
}
