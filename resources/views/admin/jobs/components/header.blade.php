@php
    $displayName = trim(($admin->first_name ?? '') . ' ' . ($admin->last_name ?? ''));
    $displayName = $displayName !== '' ? $displayName : ($admin->email ?? 'Admin');
@endphp

<div class="toolbar">
    <div class="page-title">
        <h1>Jobs Control Center</h1>
        <p>Platform-wide hiring pipeline with enterprise governance controls</p>
    </div>
    <div class="muted">Signed in as {{ $displayName }}</div>
</div>
