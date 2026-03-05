@php
    $displayName = trim(($admin->first_name ?? '') . ' ' . ($admin->last_name ?? ''));
    $displayName = $displayName !== '' ? $displayName : ($admin->email ?? 'Admin');
@endphp

<div class="toolbar">
    <div class="page-title">
        <h1>Reports Intelligence</h1>
        <p>Operational analytics, conversion diagnostics, and engagement performance</p>
        <p class="muted">Period: {{ $periodStart->format('M d, Y') }} - {{ $periodEnd->format('M d, Y') }}</p>
    </div>
    <div class="muted">Signed in as {{ $displayName }}</div>
</div>

<form class="filters-form" method="GET" action="{{ route('admin.reports.index') }}">
    <select class="select" name="preset">
        <option value="last7" @selected($filters['preset'] === 'last7')>Last 7 days</option>
        <option value="last30" @selected($filters['preset'] === 'last30')>Last 30 days</option>
        <option value="last90" @selected($filters['preset'] === 'last90')>Last 90 days</option>
        <option value="custom" @selected($filters['preset'] === 'custom')>Custom range</option>
    </select>

    <input class="input" type="date" name="start_date" value="{{ $filters['start_date'] }}">
    <input class="input" type="date" name="end_date" value="{{ $filters['end_date'] }}">

    <div></div>
    <div></div>

    <div class="inline-actions">
        <button type="submit" class="btn primary">Apply</button>
        <a href="{{ route('admin.reports.index') }}" class="btn">Reset</a>
        <a
            href="{{ route('admin.reports.export', ['preset' => $filters['preset'], 'start_date' => $filters['start_date'], 'end_date' => $filters['end_date']]) }}"
            class="btn"
        >Export CSV</a>
    </div>
</form>
