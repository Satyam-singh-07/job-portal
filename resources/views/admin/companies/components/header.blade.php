@php
    $displayName = trim(($admin->first_name ?? '') . ' ' . ($admin->last_name ?? ''));
    $displayName = $displayName !== '' ? $displayName : ($admin->email ?? 'Admin');
@endphp

<div class="toolbar">
    <div class="page-title">
        <h1>Company Governance</h1>
        <p>Manage employer accounts, trust signals, and platform compliance status</p>
    </div>
    <div class="muted">Signed in as {{ $displayName }}</div>
</div>
