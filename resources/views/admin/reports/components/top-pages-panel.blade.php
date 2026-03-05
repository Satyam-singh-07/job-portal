@php
    $formatDuration = static function (int $seconds): string {
        $minutes = intdiv(max(0, $seconds), 60);
        $remainingSeconds = max(0, $seconds) % 60;

        return $minutes . 'm ' . $remainingSeconds . 's';
    };
@endphp

<div class="panel">
    <div class="panel-header">
        <h3>Top Pages</h3>
        <div class="muted">By views</div>
    </div>
    <div class="activity-list">
        @forelse ($topPages as $page)
            <div class="activity-row">
                <div class="activity-name" title="{{ $page->path }}">{{ \Illuminate\Support\Str::limit($page->path, 56) }}</div>
                <div class="activity-meta">{{ number_format((int) $page->users_count) }} users</div>
                <div class="activity-meta">{{ number_format((int) $page->views) }} views</div>
            </div>
            <div class="activity-row" style="grid-template-columns:1fr;">
                <div class="activity-meta">Time spent: {{ $formatDuration((int) $page->total_seconds) }}</div>
            </div>
        @empty
            <div class="activity-row">
                <div class="activity-meta">No page activity captured for selected period.</div>
            </div>
        @endforelse
    </div>
</div>
