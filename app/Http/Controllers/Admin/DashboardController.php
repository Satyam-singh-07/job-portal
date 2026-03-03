<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\UserPageActivity;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userCounts = User::query()
            ->selectRaw('roles.name as role_name, COUNT(users.id) as total')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->groupBy('roles.name')
            ->pluck('total', 'role_name');

        $jobCounts = Job::query()
            ->selectRaw('status, COUNT(id) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $applicationCounts = JobApplication::query()
            ->selectRaw('status, COUNT(id) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $stats = [
            'total_users' => User::count(),
            'candidates' => (int) ($userCounts['candidate'] ?? 0),
            'employers' => (int) ($userCounts['employer'] ?? 0),
            'admins' => (int) ($userCounts['admin'] ?? 0),
            'jobs_total' => Job::count(),
            'jobs_published' => (int) ($jobCounts['Published'] ?? 0),
            'jobs_draft' => (int) ($jobCounts['Draft'] ?? 0),
            'jobs_closed' => (int) ($jobCounts['Closed'] ?? 0),
            'applications_total' => JobApplication::count(),
            'applications_pending' => (int) ($applicationCounts['Pending'] ?? 0),
            'applications_interviewing' => (int) ($applicationCounts['Interviewing'] ?? 0),
            'applications_offered' => (int) ($applicationCounts['Offered'] ?? 0),
            'applications_rejected' => (int) ($applicationCounts['Rejected'] ?? 0),
            'conversations' => Conversation::count(),
            'messages' => DB::table('messages')->count(),
            'followings' => DB::table('employer_followers')->count(),
        ];

        $latestUsers = User::query()
            ->with('role:id,name')
            ->latest()
            ->take(8)
            ->get(['id', 'first_name', 'last_name', 'email', 'role_id', 'created_at']);

        $recentJobs = Job::query()
            ->with('user:id,company_name,email')
            ->withCount('applications')
            ->latest()
            ->take(6)
            ->get(['id', 'user_id', 'title', 'status', 'location', 'created_at']);

        $recentApplicants = JobApplication::query()
            ->with([
                'user:id,first_name,last_name,email',
                'user.candidateProfile:user_id,skills',
                'job:id,title',
            ])
            ->latest()
            ->take(3)
            ->get(['id', 'job_id', 'user_id', 'status', 'created_at']);

        $dailyCounts = JobApplication::query()
            ->whereDate('created_at', '>=', now()->subDays(6)->toDateString())
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $applicationSeries = collect(range(6, 0))
            ->map(function (int $offset) use ($dailyCounts): array {
                $date = now()->subDays($offset);
                $key = $date->toDateString();

                return [
                    'label' => $date->format('D'),
                    'count' => (int) ($dailyCounts[$key] ?? 0),
                ];
            })
            ->values();

        $maxSeriesCount = max($applicationSeries->max('count'), 1);
        $applicationSeries = $applicationSeries->map(function (array $point) use ($maxSeriesCount): array {
            $point['height'] = (int) round(($point['count'] / $maxSeriesCount) * 140);
            return $point;
        });

        $currentPeriod = JobApplication::query()
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $previousPeriod = JobApplication::query()
            ->whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])
            ->count();

        $applicationsGrowthPercent = $previousPeriod > 0
            ? (int) round((($currentPeriod - $previousPeriod) / $previousPeriod) * 100)
            : ($currentPeriod > 0 ? 100 : 0);

        $statCards = [
            ['icon' => 'fas fa-file-signature', 'title' => 'Active Jobs', 'value' => number_format($stats['jobs_published']), 'trend' => $stats['jobs_draft'].' drafts pending', 'trend_neutral' => true],
            ['icon' => 'fas fa-user-check', 'title' => 'Applications', 'value' => number_format($stats['applications_total']), 'trend' => $applicationsGrowthPercent.'% vs last month', 'trend_neutral' => false],
            ['icon' => 'fas fa-clock', 'title' => 'Interviews', 'value' => number_format($stats['applications_interviewing']), 'trend' => $stats['applications_pending'].' pending review', 'trend_neutral' => true],
            ['icon' => 'fas fa-star', 'title' => 'Shortlisted', 'value' => number_format($stats['applications_offered']), 'trend' => $stats['applications_rejected'].' rejected', 'trend_neutral' => false],
        ];

        $quickActions = [
            ['icon' => 'fas fa-users', 'label' => 'View Users', 'url' => '#'],
            ['icon' => 'fas fa-briefcase', 'label' => 'Review Jobs', 'url' => route('admin.jobs.index')],
            ['icon' => 'fas fa-building', 'label' => 'Manage Companies', 'url' => route('admin.companies.index')],
            ['icon' => 'fas fa-chart-line', 'label' => 'Refresh Insights', 'url' => route('admin.dashboard')],
        ];

        $trackingStartDate = now()->subDays(6)->toDateString();

        $topUsersByTime = UserPageActivity::query()
            ->with('user:id,first_name,last_name,email')
            ->selectRaw('user_id, SUM(total_seconds) as total_seconds, MAX(last_seen_at) as last_seen_at')
            ->whereDate('activity_date', '>=', $trackingStartDate)
            ->groupBy('user_id')
            ->orderByDesc('total_seconds')
            ->take(8)
            ->get();

        $recentPageActivity = UserPageActivity::query()
            ->with('user:id,first_name,last_name,email')
            ->whereDate('activity_date', '>=', $trackingStartDate)
            ->latest('last_seen_at')
            ->take(10)
            ->get(['id', 'user_id', 'path', 'page_title', 'total_seconds', 'last_seen_at', 'activity_date']);

        $topPagesByTime = UserPageActivity::query()
            ->selectRaw('path, SUM(total_seconds) as total_seconds, COUNT(DISTINCT user_id) as unique_users')
            ->whereDate('activity_date', '>=', $trackingStartDate)
            ->groupBy('path')
            ->orderByDesc('total_seconds')
            ->take(8)
            ->get();

        $portalTrackedSeconds = (int) UserPageActivity::query()
            ->whereDate('activity_date', '>=', $trackingStartDate)
            ->sum('total_seconds');

        $activeUsersTracked = (int) UserPageActivity::query()
            ->whereDate('activity_date', '>=', $trackingStartDate)
            ->distinct('user_id')
            ->count('user_id');

        return view('admin.dashboard', compact(
            'stats',
            'latestUsers',
            'recentJobs',
            'recentApplicants',
            'applicationSeries',
            'applicationsGrowthPercent',
            'statCards',
            'quickActions',
            'topUsersByTime',
            'recentPageActivity',
            'topPagesByTime',
            'portalTrackedSeconds',
            'activeUsersTracked'
        ));
    }
}
