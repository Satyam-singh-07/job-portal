<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobView;
use App\Models\Message;
use App\Models\ResumeView;
use App\Models\User;
use App\Models\UserPageActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'preset' => ['nullable', 'in:last7,last30,last90,custom'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
        ]);

        [$periodStart, $periodEnd, $filters] = $this->resolvePeriod($validated);
        [$previousStart, $previousEnd] = $this->previousPeriod($periodStart, $periodEnd);

        $current = $this->periodMetrics($periodStart, $periodEnd);
        $previous = $this->periodMetrics($previousStart, $previousEnd);

        $stats = [
            [
                'icon' => 'fas fa-eye',
                'title' => 'Page Views',
                'value' => number_format($current['page_views']),
                'trend' => $this->formatTrend($current['page_views'], $previous['page_views']),
                'trend_down' => $current['page_views'] < $previous['page_views'],
            ],
            [
                'icon' => 'fas fa-users',
                'title' => 'Unique Visitors',
                'value' => number_format($current['unique_visitors']),
                'trend' => $this->formatTrend($current['unique_visitors'], $previous['unique_visitors']),
                'trend_down' => $current['unique_visitors'] < $previous['unique_visitors'],
            ],
            [
                'icon' => 'fas fa-file-signature',
                'title' => 'Applications',
                'value' => number_format($current['applications']),
                'trend' => $this->formatTrend($current['applications'], $previous['applications']),
                'trend_down' => $current['applications'] < $previous['applications'],
            ],
            [
                'icon' => 'fas fa-clock',
                'title' => 'Avg Session',
                'value' => $this->formatDuration($current['avg_session_seconds']),
                'trend' => $this->formatTrend($current['avg_session_seconds'], $previous['avg_session_seconds']),
                'trend_down' => $current['avg_session_seconds'] < $previous['avg_session_seconds'],
            ],
        ];

        $dailySeries = $this->buildDailySeries($periodStart, $periodEnd);
        $roleSegments = $this->roleSegments($periodStart, $periodEnd);
        $applicationStatusBreakdown = $this->applicationStatusBreakdown($periodStart, $periodEnd);
        $topPages = $this->topPages($periodStart, $periodEnd);
        $engagement = $this->engagementMetrics($periodStart, $periodEnd);

        return view('admin.reports.index', [
            'sidebarStats' => ['total_users' => User::count()],
            'filters' => $filters,
            'periodStart' => $periodStart,
            'periodEnd' => $periodEnd,
            'previousStart' => $previousStart,
            'previousEnd' => $previousEnd,
            'stats' => $stats,
            'dailySeries' => $dailySeries,
            'roleSegments' => $roleSegments,
            'applicationStatusBreakdown' => $applicationStatusBreakdown,
            'topPages' => $topPages,
            'engagement' => $engagement,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $validated = $request->validate([
            'preset' => ['nullable', 'in:last7,last30,last90,custom'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
        ]);

        [$periodStart, $periodEnd] = $this->resolvePeriod($validated);
        $metrics = $this->periodMetrics($periodStart, $periodEnd);

        $filename = 'admin-report-' . $periodStart->toDateString() . '-to-' . $periodEnd->toDateString() . '.csv';

        return response()->streamDownload(function () use ($metrics, $periodStart, $periodEnd): void {
            $output = fopen('php://output', 'wb');
            fputcsv($output, ['metric', 'value', 'period_start', 'period_end']);
            fputcsv($output, ['page_views', $metrics['page_views'], $periodStart->toDateString(), $periodEnd->toDateString()]);
            fputcsv($output, ['unique_visitors', $metrics['unique_visitors'], $periodStart->toDateString(), $periodEnd->toDateString()]);
            fputcsv($output, ['applications', $metrics['applications'], $periodStart->toDateString(), $periodEnd->toDateString()]);
            fputcsv($output, ['avg_session_seconds', $metrics['avg_session_seconds'], $periodStart->toDateString(), $periodEnd->toDateString()]);
            fputcsv($output, ['job_views', $metrics['job_views'], $periodStart->toDateString(), $periodEnd->toDateString()]);
            fputcsv($output, ['resume_views', $metrics['resume_views'], $periodStart->toDateString(), $periodEnd->toDateString()]);
            fputcsv($output, ['messages', $metrics['messages'], $periodStart->toDateString(), $periodEnd->toDateString()]);
            fputcsv($output, ['followings', $metrics['followings'], $periodStart->toDateString(), $periodEnd->toDateString()]);
            fclose($output);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function resolvePeriod(array $validated): array
    {
        $preset = $validated['preset'] ?? 'last30';
        $today = now()->endOfDay();

        if ($preset === 'last7') {
            $start = now()->subDays(6)->startOfDay();
            $end = $today;
        } elseif ($preset === 'last90') {
            $start = now()->subDays(89)->startOfDay();
            $end = $today;
        } elseif ($preset === 'custom') {
            $startDate = $validated['start_date'] ?? now()->subDays(29)->toDateString();
            $endDate = $validated['end_date'] ?? now()->toDateString();
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();
            if ($start->gt($end)) {
                [$start, $end] = [$end->copy()->startOfDay(), $start->copy()->endOfDay()];
            }
        } else {
            $start = now()->subDays(29)->startOfDay();
            $end = $today;
            $preset = 'last30';
        }

        return [$start, $end, [
            'preset' => $preset,
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
        ]];
    }

    private function previousPeriod(Carbon $start, Carbon $end): array
    {
        $days = $start->diffInDays($end) + 1;
        $previousEnd = $start->copy()->subDay()->endOfDay();
        $previousStart = $previousEnd->copy()->subDays($days - 1)->startOfDay();

        return [$previousStart, $previousEnd];
    }

    private function periodMetrics(Carbon $start, Carbon $end): array
    {
        $startDate = $start->toDateString();
        $endDate = $end->toDateString();

        $pageViews = UserPageActivity::query()
            ->whereBetween('activity_date', [$startDate, $endDate])
            ->count();

        $uniqueVisitors = UserPageActivity::query()
            ->whereBetween('activity_date', [$startDate, $endDate])
            ->distinct('user_id')
            ->count('user_id');

        $applications = JobApplication::query()
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $avgSessionSeconds = (int) round((float) UserPageActivity::query()
            ->whereBetween('activity_date', [$startDate, $endDate])
            ->avg('total_seconds'));

        $jobViews = JobView::query()
            ->whereBetween('viewed_on', [$startDate, $endDate])
            ->count();

        $resumeViews = ResumeView::query()
            ->whereBetween('viewed_at', [$start, $end])
            ->count();

        $messages = Message::query()
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $followings = DB::table('employer_followers')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        return [
            'page_views' => $pageViews,
            'unique_visitors' => $uniqueVisitors,
            'applications' => $applications,
            'avg_session_seconds' => $avgSessionSeconds,
            'job_views' => $jobViews,
            'resume_views' => $resumeViews,
            'messages' => $messages,
            'followings' => $followings,
        ];
    }

    private function buildDailySeries(Carbon $start, Carbon $end)
    {
        $rows = UserPageActivity::query()
            ->whereBetween('activity_date', [$start->toDateString(), $end->toDateString()])
            ->selectRaw('activity_date as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $series = collect();
        $cursor = $start->copy();
        while ($cursor->lte($end)) {
            $day = $cursor->toDateString();
            $series->push([
                'label' => $cursor->format('M d'),
                'count' => (int) ($rows[$day] ?? 0),
            ]);
            $cursor->addDay();
        }

        $max = max((int) $series->max('count'), 1);

        return $series->map(function (array $point) use ($max): array {
            $point['height'] = (int) round(($point['count'] / $max) * 150);
            return $point;
        });
    }

    private function roleSegments(Carbon $start, Carbon $end)
    {
        $rows = UserPageActivity::query()
            ->join('users', 'users.id', '=', 'user_page_activities.user_id')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->whereBetween('user_page_activities.activity_date', [$start->toDateString(), $end->toDateString()])
            ->selectRaw('roles.name as role_name, COUNT(DISTINCT user_page_activities.user_id) as users_count, SUM(user_page_activities.total_seconds) as total_seconds')
            ->groupBy('roles.name')
            ->orderByDesc('users_count')
            ->get();

        $totalUsers = (int) $rows->sum('users_count');

        return $rows->map(function ($row) use ($totalUsers): array {
            $percent = $totalUsers > 0 ? (int) round(((int) $row->users_count / $totalUsers) * 100) : 0;
            return [
                'role' => ucfirst((string) $row->role_name),
                'users_count' => (int) $row->users_count,
                'total_seconds' => (int) $row->total_seconds,
                'percent' => $percent,
            ];
        });
    }

    private function applicationStatusBreakdown(Carbon $start, Carbon $end)
    {
        $rows = JobApplication::query()
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->orderByDesc('total')
            ->get();

        $total = (int) $rows->sum('total');

        return $rows->map(function ($row) use ($total): array {
            $count = (int) $row->total;
            $percent = $total > 0 ? (int) round(($count / $total) * 100) : 0;
            return [
                'status' => (string) $row->status,
                'count' => $count,
                'percent' => $percent,
            ];
        });
    }

    private function topPages(Carbon $start, Carbon $end)
    {
        return UserPageActivity::query()
            ->whereBetween('activity_date', [$start->toDateString(), $end->toDateString()])
            ->selectRaw('path, COUNT(*) as views, COUNT(DISTINCT user_id) as users_count, SUM(total_seconds) as total_seconds')
            ->groupBy('path')
            ->orderByDesc('views')
            ->limit(8)
            ->get();
    }

    private function engagementMetrics(Carbon $start, Carbon $end): array
    {
        $metrics = $this->periodMetrics($start, $end);
        $applicationToJobView = $metrics['job_views'] > 0
            ? (int) round(($metrics['applications'] / $metrics['job_views']) * 100)
            : 0;

        $resumeViewRate = $metrics['applications'] > 0
            ? (int) round(($metrics['resume_views'] / $metrics['applications']) * 100)
            : 0;

        return [
            'job_views' => $metrics['job_views'],
            'resume_views' => $metrics['resume_views'],
            'messages' => $metrics['messages'],
            'followings' => $metrics['followings'],
            'application_to_job_view_percent' => $applicationToJobView,
            'resume_view_percent' => $resumeViewRate,
        ];
    }

    private function formatDuration(int $seconds): string
    {
        $seconds = max(0, $seconds);
        $minutes = intdiv($seconds, 60);
        $remaining = $seconds % 60;

        return $minutes . 'm ' . $remaining . 's';
    }

    private function formatTrend(int $current, int $previous): string
    {
        if ($previous <= 0) {
            return $current > 0 ? '+100%' : '0%';
        }

        $delta = (int) round((($current - $previous) / $previous) * 100);
        return ($delta >= 0 ? '+' : '') . $delta . '%';
    }
}
