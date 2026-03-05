<!DOCTYPE html>
<html lang="en">
@include('admin.components.styles')
<body>
    <div class="dashboard">
        @include('admin.components.sidebar', ['stats' => $stats])

        <main class="main">
            @include('admin.components.header', ['admin' => auth()->user()])
            @include('admin.components.stat-cards', ['statCards' => $statCards])

            <div class="insight-panels">
                @include('admin.components.recent-jobs-panel', ['recentJobs' => $recentJobs, 'stats' => $stats])
                @include('admin.components.applications-panel', [
                    'applicationSeries' => $applicationSeries,
                    'applicationsGrowthPercent' => $applicationsGrowthPercent,
                    'recentApplicants' => $recentApplicants,
                ])
            </div>

            @include('admin.components.quick-actions', ['quickActions' => $quickActions])
            @include('admin.components.latest-users-panel', ['latestUsers' => $latestUsers])

            <div class="insight-panels">
                @include('admin.components.user-activity-panel', [
                    'recentPageActivity' => $recentPageActivity,
                    'topUsersByTime' => $topUsersByTime,
                    'portalTrackedSeconds' => $portalTrackedSeconds,
                    'activeUsersTracked' => $activeUsersTracked,
                ])
                @include('admin.components.page-insights-panel', ['topPagesByTime' => $topPagesByTime])
            </div>
        </main>
    </div>
</body>
</html>
