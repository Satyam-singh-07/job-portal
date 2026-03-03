@php
    $formatDuration = static function (int $seconds): string {
        $hours = intdiv($seconds, 3600);
        $minutes = intdiv($seconds % 3600, 60);

        if ($hours > 0) {
            return $hours.'h '.$minutes.'m';
        }

        return max(1, $minutes).'m';
    };
@endphp

<div class="panel">
    <div class="panel-header">
        <h3>Most visited pages (last 7 days)</h3>
        <a href="{{ route('admin.dashboard') }}">View live</a>
    </div>

    <div class="activity-list">
        @forelse ($topPagesByTime as $page)
            <div class="activity-row">
                <div class="activity-name" title="{{ $page->path }}">{{ \Illuminate\Support\Str::limit($page->path, 60) }}</div>
                <div class="activity-meta">{{ number_format((int) $page->unique_users) }} users</div>
                <div class="activity-meta">{{ $formatDuration((int) $page->total_seconds) }}</div>
            </div>
        @empty
            <div class="activity-row">
                <div class="activity-meta">No page insights available yet.</div>
            </div>
        @endforelse
    </div>
</div>
