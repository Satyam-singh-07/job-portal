@php
    $displayName = trim(($admin->first_name ?? '') . ' ' . ($admin->last_name ?? ''));
    $displayName = $displayName !== '' ? $displayName : ($admin->email ?? 'Admin');
@endphp

<div class="toolbar">
    <div class="page-title">
        <h1>Settings & Quotas</h1>
        <p>Manage platform defaults and monitor candidate/employer credit balances</p>
    </div>
    <div class="muted">Signed in as {{ $displayName }}</div>
</div>
