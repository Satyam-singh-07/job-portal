<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:200'],
            'status' => ['nullable', 'in:Draft,Published,Closed'],
            'employment_type' => ['nullable', 'string', 'max:120'],
            'employer_id' => ['nullable', 'integer', 'exists:users,id'],
            'sort' => ['nullable', 'in:latest,oldest,applications,title_asc,title_desc'],
        ]);

        $query = Job::query()
            ->with('user:id,first_name,last_name,company_name,email')
            ->withCount('applications');

        if (!empty($validated['search'])) {
            $search = trim($validated['search']);
            $query->where(function ($inner) use ($search): void {
                $inner->where('title', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('employment_type', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search): void {
                        $userQuery->where('company_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        if (!empty($validated['employment_type'])) {
            $query->where('employment_type', $validated['employment_type']);
        }

        if (!empty($validated['employer_id'])) {
            $query->where('user_id', (int) $validated['employer_id']);
        }

        $sort = $validated['sort'] ?? 'latest';
        if ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'applications') {
            $query->orderByDesc('applications_count')->latest();
        } elseif ($sort === 'title_asc') {
            $query->orderBy('title');
        } elseif ($sort === 'title_desc') {
            $query->orderByDesc('title');
        } else {
            $query->latest();
        }

        $jobs = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Job::count(),
            'published' => Job::where('status', 'Published')->count(),
            'draft' => Job::where('status', 'Draft')->count(),
            'closed' => Job::where('status', 'Closed')->count(),
            'applications_total' => DB::table('job_applications')->count(),
        ];

        $employers = User::query()
            ->whereHas('jobs')
            ->orderByRaw('COALESCE(company_name, email) asc')
            ->get(['id', 'company_name', 'email']);

        $employmentTypes = Job::query()
            ->select('employment_type')
            ->whereNotNull('employment_type')
            ->distinct()
            ->orderBy('employment_type')
            ->pluck('employment_type');

        return view('admin.jobs.index', [
            'jobs' => $jobs,
            'stats' => $stats,
            'sidebarStats' => [
                'total_users' => User::count(),
            ],
            'employers' => $employers,
            'employmentTypes' => $employmentTypes,
            'filters' => [
                'search' => $validated['search'] ?? '',
                'status' => $validated['status'] ?? '',
                'employment_type' => $validated['employment_type'] ?? '',
                'employer_id' => (string) ($validated['employer_id'] ?? ''),
                'sort' => $sort,
            ],
        ]);
    }

    public function show(Job $job): View
    {
        $job->load([
            'user:id,first_name,last_name,company_name,email',
            'applications' => function ($query): void {
                $query->with('user:id,first_name,last_name,email')->latest()->limit(12);
            },
        ])->loadCount('applications');

        return view('admin.jobs.show', [
            'job' => $job,
            'stats' => [
                'total_users' => User::count(),
            ],
        ]);
    }

    public function updateStatus(Request $request, Job $job): RedirectResponse
    {
        $payload = $request->validate([
            'status' => ['required', 'in:Draft,Published,Closed'],
        ]);

        $job->update(['status' => $payload['status']]);

        return back()->with('success', 'Job status updated successfully.');
    }

    public function destroy(Job $job): RedirectResponse
    {
        $job->delete();

        return back()->with('success', 'Job removed successfully.');
    }
}
