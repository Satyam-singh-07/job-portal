<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-title"><i class="fas fa-building"></i> Companies</div>
        <div class="stat-value">{{ number_format($stats['companies_total'] ?? 0) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title"><i class="fas fa-circle-check"></i> Active</div>
        <div class="stat-value">{{ number_format($stats['companies_active'] ?? 0) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title"><i class="fas fa-ban"></i> Suspended</div>
        <div class="stat-value">{{ number_format($stats['companies_suspended'] ?? 0) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title"><i class="fas fa-wallet"></i> Remaining Credits</div>
        <div class="stat-value">{{ number_format($stats['posting_balance_total'] ?? 0) }}</div>
    </div>
</div>
