@php
    $displayName = trim(($admin->first_name ?? '') . ' ' . ($admin->last_name ?? ''));
    $displayName = $displayName !== '' ? $displayName : ($admin->email ?? 'Admin');
    $initial = strtoupper(substr($displayName, 0, 1));
@endphp

<div class="header">
    <div class="page-title">
        <h1>Welcome, {{ $displayName }}</h1>
        <p>Live snapshot of platform activity and hiring performance</p>
    </div>
    <div class="header-right">
        <form class="search-bar" action="{{ route('jobs.index') }}" method="GET">
            <i class="fas fa-search"></i>
            <input type="text" name="search" placeholder="Search jobs...">
        </form>
        <div class="profile-pic">{{ $initial }}</div>
    </div>
</div>
