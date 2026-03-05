<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlatformSetting;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $candidateRoleId = (int) Role::query()->where('name', 'candidate')->value('id');
        $employerRoleId = (int) Role::query()->where('name', 'employer')->value('id');

        $defaults = [
            'candidate_default_application_balance' => PlatformSetting::getInt('candidate_default_application_balance', 25),
            'employer_default_posting_balance' => PlatformSetting::getInt('employer_default_posting_balance', 10),
        ];

        $stats = [
            'total_users' => User::count(),
            'candidate_balance_total' => (int) User::query()->where('role_id', $candidateRoleId)->sum('job_application_balance'),
            'employer_balance_total' => (int) User::query()->where('role_id', $employerRoleId)->sum('job_posting_balance'),
            'low_candidate_accounts' => (int) User::query()->where('role_id', $candidateRoleId)->where('job_application_balance', '<=', 2)->count(),
            'low_employer_accounts' => (int) User::query()->where('role_id', $employerRoleId)->where('job_posting_balance', '<=', 2)->count(),
        ];

        $lowBalanceCandidates = User::query()
            ->where('role_id', $candidateRoleId)
            ->withCount('applications')
            ->where('job_application_balance', '<=', 2)
            ->orderBy('job_application_balance')
            ->orderByDesc('updated_at')
            ->take(8)
            ->get(['id', 'first_name', 'last_name', 'email', 'job_application_balance']);

        $lowBalanceEmployers = User::query()
            ->where('role_id', $employerRoleId)
            ->withCount([
                'jobs as published_jobs_count' => fn ($q) => $q->where('status', 'Published'),
            ])
            ->where('job_posting_balance', '<=', 2)
            ->orderBy('job_posting_balance')
            ->orderByDesc('updated_at')
            ->take(8)
            ->get(['id', 'company_name', 'email', 'job_posting_balance']);

        return view('admin.settings.index', [
            'sidebarStats' => ['total_users' => $stats['total_users']],
            'defaults' => $defaults,
            'stats' => $stats,
            'lowBalanceCandidates' => $lowBalanceCandidates,
            'lowBalanceEmployers' => $lowBalanceEmployers,
        ]);
    }

    public function updateDefaultBalances(Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'candidate_default_application_balance' => ['required', 'integer', 'min:0', 'max:100000'],
            'employer_default_posting_balance' => ['required', 'integer', 'min:0', 'max:100000'],
        ]);

        PlatformSetting::setInt('candidate_default_application_balance', (int) $payload['candidate_default_application_balance']);
        PlatformSetting::setInt('employer_default_posting_balance', (int) $payload['employer_default_posting_balance']);

        return back()->with('success', 'Default balances updated successfully.');
    }
}
