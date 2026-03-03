<div class="panel">
    <div class="panel-header">
        <h3>Application Funnel</h3>
        <div class="muted">Status breakdown</div>
    </div>
    <div class="activity-list">
        @forelse ($applicationStatusBreakdown as $item)
            <div class="activity-row">
                <div class="activity-name">{{ $item['status'] }}</div>
                <div class="activity-meta">{{ number_format($item['count']) }} applications</div>
                <div class="activity-meta">{{ $item['percent'] }}%</div>
            </div>
        @empty
            <div class="activity-row">
                <div class="activity-meta">No applications found in selected period.</div>
            </div>
        @endforelse
    </div>
</div>
