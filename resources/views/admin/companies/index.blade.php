<!DOCTYPE html>
<html lang="en">
@include('admin.components.styles')
<body>
    <div class="dashboard">
        @include('admin.components.sidebar', ['stats' => $sidebarStats])

        <main class="main">
            @include('admin.companies.components.header', ['admin' => auth()->user()])
            @include('admin.companies.components.stat-cards', ['stats' => $stats])
            @include('admin.companies.components.filters', ['filters' => $filters, 'industries' => $industries])
            @include('admin.companies.components.table', ['companies' => $companies])
        </main>
    </div>
</body>
</html>
