<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-title"><i class="fas fa-user-check"></i> Candidate Credits</div>
        <div class="stat-value">{{ number_format($stats['candidate_balance_total'] ?? 0) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title"><i class="fas fa-building-circle-check"></i> Employer Credits</div>
        <div class="stat-value">{{ number_format($stats['employer_balance_total'] ?? 0) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title"><i class="fas fa-triangle-exclamation"></i> Low Candidate Balances</div>
        <div class="stat-value">{{ number_format($stats['low_candidate_accounts'] ?? 0) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title"><i class="fas fa-triangle-exclamation"></i> Low Employer Balances</div>
        <div class="stat-value">{{ number_format($stats['low_employer_accounts'] ?? 0) }}</div>
    </div>
</div>
