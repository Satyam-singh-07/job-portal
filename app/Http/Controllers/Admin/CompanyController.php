<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:200'],
            'industry' => ['nullable', 'string', 'max:120'],
            'status' => ['nullable', 'in:Active,Suspended'],
            'sort' => ['nullable', 'in:latest,oldest,name_asc,name_desc,jobs_desc,applications_desc,rating_desc,rating_asc'],
        ]);

        $employerRoleId = (int) Role::query()->where('name', 'employer')->value('id');

        $query = User::query()
            ->where('role_id', $employerRoleId)
            ->withCount([
                'jobs',
                'jobs as published_jobs_count' => function ($q): void {
                    $q->where('status', 'Published');
                },
                'followers',
            ])
            ->addSelect([
                'applications_count' => JobApplication::query()
                    ->selectRaw('COUNT(job_applications.id)')
                    ->join('jobs', 'jobs.id', '=', 'job_applications.job_id')
                    ->whereColumn('jobs.user_id', 'users.id'),
            ]);

        if (!empty($validated['search'])) {
            $search = trim($validated['search']);
            $query->where(function ($inner) use ($search): void {
                $inner->where('company_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('industry', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            });
        }

        if (!empty($validated['industry'])) {
            $query->where('industry', $validated['industry']);
        }

        if (!empty($validated['status'])) {
            $query->where('account_status', $validated['status']);
        }

        $sort = $validated['sort'] ?? 'latest';
        if ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'name_asc') {
            $query->orderByRaw('COALESCE(company_name, email) asc');
        } elseif ($sort === 'name_desc') {
            $query->orderByRaw('COALESCE(company_name, email) desc');
        } elseif ($sort === 'jobs_desc') {
            $query->orderByDesc('published_jobs_count')->latest();
        } elseif ($sort === 'applications_desc') {
            $query->orderByDesc('applications_count')->latest();
        } elseif ($sort === 'rating_desc') {
            $query->orderByDesc('rating')->latest();
        } elseif ($sort === 'rating_asc') {
            $query->orderBy('rating')->latest();
        } else {
            $query->latest();
        }

        $companies = $query->paginate(15)->withQueryString();

        $stats = [
            'companies_total' => User::query()->where('role_id', $employerRoleId)->count(),
            'companies_active' => User::query()->where('role_id', $employerRoleId)->where('account_status', 'Active')->count(),
            'companies_suspended' => User::query()->where('role_id', $employerRoleId)->where('account_status', 'Suspended')->count(),
            'open_jobs' => Job::query()->where('status', 'Published')->count(),
            'applications_total' => DB::table('job_applications')->count(),
            'posting_balance_total' => (int) User::query()
                ->where('role_id', $employerRoleId)
                ->sum('job_posting_balance'),
        ];

        $industries = User::query()
            ->where('role_id', $employerRoleId)
            ->whereNotNull('industry')
            ->where('industry', '!=', '')
            ->distinct()
            ->orderBy('industry')
            ->pluck('industry');

        return view('admin.companies.index', [
            'companies' => $companies,
            'stats' => $stats,
            'sidebarStats' => ['total_users' => User::count()],
            'industries' => $industries,
            'filters' => [
                'search' => $validated['search'] ?? '',
                'industry' => $validated['industry'] ?? '',
                'status' => $validated['status'] ?? '',
                'sort' => $sort,
            ],
        ]);
    }

    public function show(User $company): View
    {
        abort_unless($company->isEmployer(), 404);

        $company->loadCount([
            'jobs',
            'jobs as published_jobs_count' => function ($q): void {
                $q->where('status', 'Published');
            },
            'followers',
        ]);

        $recentJobs = Job::query()
            ->where('user_id', $company->id)
            ->withCount('applications')
            ->latest()
            ->take(10)
            ->get(['id', 'title', 'status', 'location', 'employment_type', 'created_at']);

        $recentApplications = JobApplication::query()
            ->whereHas('job', function ($q) use ($company): void {
                $q->where('user_id', $company->id);
            })
            ->with(['user:id,first_name,last_name,email', 'job:id,title'])
            ->latest()
            ->take(10)
            ->get(['id', 'job_id', 'user_id', 'status', 'created_at']);

        $applicationsTotal = JobApplication::query()
            ->whereHas('job', function ($q) use ($company): void {
                $q->where('user_id', $company->id);
            })
            ->count();

        return view('admin.companies.show', [
            'company' => $company,
            'recentJobs' => $recentJobs,
            'recentApplications' => $recentApplications,
            'applicationsTotal' => $applicationsTotal,
            'stats' => ['total_users' => User::count()],
        ]);
    }

    public function updateStatus(Request $request, User $company): RedirectResponse
    {
        abort_unless($company->isEmployer(), 404);

        $payload = $request->validate([
            'account_status' => ['required', 'in:Active,Suspended'],
        ]);

        $company->update(['account_status' => $payload['account_status']]);

        return back()->with('success', 'Company account status updated.');
    }

    public function updateRating(Request $request, User $company): RedirectResponse
    {
        abort_unless($company->isEmployer(), 404);

        $payload = $request->validate([
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
        ]);

        $company->update(['rating' => round((float) $payload['rating'], 2)]);

        return back()->with('success', 'Company rating updated.');
    }

    public function updatePostingBalance(Request $request, User $company): RedirectResponse
    {
        abort_unless($company->isEmployer(), 404);

        $payload = $request->validate([
            'balance_action' => ['required', 'in:set,add,subtract'],
            'amount' => ['required', 'integer', 'min:0', 'max:100000'],
        ]);

        $amount = (int) $payload['amount'];
        $current = (int) ($company->job_posting_balance ?? 0);

        if ($payload['balance_action'] === 'set') {
            $next = $amount;
        } elseif ($payload['balance_action'] === 'add') {
            $next = $current + $amount;
        } else {
            $next = max(0, $current - $amount);
        }

        $company->update(['job_posting_balance' => $next]);

        return back()->with('success', 'Company posting balance updated.');
    }
}
