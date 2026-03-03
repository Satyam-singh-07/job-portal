@php
    $formatDuration = static function (int $seconds): string {
        $minutes = intdiv(max(0, $seconds), 60);
        $remainingSeconds = max(0, $seconds) % 60;

        return $minutes . 'm ' . $remainingSeconds . 's';
    };
@endphp

<div class="panel">
    <div class="panel-header">
        <h3>Active User Segments</h3>
        <div class="muted">By role</div>
    </div>
    <div class="activity-list">
        @forelse ($roleSegments as $segment)
            <div class="activity-row">
                <div class="activity-name">{{ $segment['role'] }}</div>
                <div class="activity-meta">{{ number_format($segment['users_count']) }} users</div>
                <div class="activity-meta">{{ $segment['percent'] }}%</div>
            </div>
            <div class="activity-row" style="grid-template-columns:1fr;">
                <div class="activity-meta">Tracked time: {{ $formatDuration((int) $segment['total_seconds']) }}</div>
            </div>
        @empty
            <div class="activity-row">
                <div class="activity-meta">No active segments for selected period.</div>
            </div>
        @endforelse
    </div>
</div>
