<!DOCTYPE html>
<html lang="en">
@include('admin.components.styles')
<body>
    <div class="dashboard">
        @include('admin.components.sidebar', ['stats' => $sidebarStats])

        <main class="main">
            @include('admin.reports.components.header', [
                'admin' => auth()->user(),
                'filters' => $filters,
                'periodStart' => $periodStart,
                'periodEnd' => $periodEnd,
            ])
            @include('admin.reports.components.stat-cards', ['stats' => $stats])

            <div class="insight-panels">
                @include('admin.reports.components.visits-panel', ['dailySeries' => $dailySeries])
                @include('admin.reports.components.segments-panel', ['roleSegments' => $roleSegments])
            </div>

            <div class="insight-panels">
                @include('admin.reports.components.top-pages-panel', ['topPages' => $topPages])
                @include('admin.reports.components.funnel-panel', ['applicationStatusBreakdown' => $applicationStatusBreakdown])
            </div>

            @include('admin.reports.components.engagement-panel', [
                'engagement' => $engagement,
                'periodStart' => $periodStart,
                'periodEnd' => $periodEnd,
                'filters' => $filters,
            ])
        </main>
    </div>
</body>
</html>
