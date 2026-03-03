<!DOCTYPE html>
<html lang="en">
@include('admin.components.styles')
<body>
    <div class="dashboard">
        @include('admin.components.sidebar', ['stats' => $sidebarStats])

        <main class="main">
            @include('admin.jobs.components.header', ['admin' => auth()->user()])
            @include('admin.jobs.components.stat-cards', ['stats' => $stats])
            @include('admin.jobs.components.filters', ['filters' => $filters, 'employers' => $employers, 'employmentTypes' => $employmentTypes])
            @include('admin.jobs.components.table', ['jobs' => $jobs])
        </main>
    </div>
</body>
</html>
