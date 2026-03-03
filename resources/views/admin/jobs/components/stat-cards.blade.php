<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-title"><i class="fas fa-briefcase"></i> Total jobs</div>
        <div class="stat-value">{{ number_format($stats['total'] ?? 0) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title"><i class="fas fa-bullhorn"></i> Published</div>
        <div class="stat-value">{{ number_format($stats['published'] ?? 0) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title"><i class="fas fa-file-alt"></i> Draft</div>
        <div class="stat-value">{{ number_format($stats['draft'] ?? 0) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title"><i class="fas fa-inbox"></i> Applications</div>
        <div class="stat-value">{{ number_format($stats['applications_total'] ?? 0) }}</div>
    </div>
</div>
