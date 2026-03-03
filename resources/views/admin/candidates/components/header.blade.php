@php
    $displayName = trim(($admin->first_name ?? '') . ' ' . ($admin->last_name ?? ''));
    $displayName = $displayName !== '' ? $displayName : ($admin->email ?? 'Admin');
@endphp

<div class="toolbar">
    <div class="page-title">
        <h1>Candidate Operations</h1>
        <p>Monitor talent health, engagement, and account compliance across the platform</p>
    </div>
    <div class="muted">Signed in as {{ $displayName }}</div>
</div>
