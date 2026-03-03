<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-title"><i class="fas fa-users"></i> Candidates</div>
        <div class="stat-value">{{ number_format($stats['total'] ?? 0) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title"><i class="fas fa-circle-check"></i> Active</div>
        <div class="stat-value">{{ number_format($stats['active'] ?? 0) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title"><i class="fas fa-bullhorn"></i> Open to work</div>
        <div class="stat-value">{{ number_format($stats['open_to_work'] ?? 0) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title"><i class="fas fa-wallet"></i> Remaining Credits</div>
        <div class="stat-value">{{ number_format($stats['application_balance_total'] ?? 0) }}</div>
    </div>
</div>
