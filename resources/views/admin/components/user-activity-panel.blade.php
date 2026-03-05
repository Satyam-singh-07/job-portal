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
        <h3>User activity (last 7 days)</h3>
        <a href="{{ route('admin.dashboard') }}">Refresh <i class="fas fa-sync-alt"></i></a>
    </div>

    <div class="legend" style="margin-bottom: 1rem;">
        <span><i class="fas fa-clock" style="color:#2e5fd7;"></i> {{ $formatDuration((int) $portalTrackedSeconds) }} tracked time</span>
        <span><i class="fas fa-users" style="color:#2e5fd7;"></i> {{ number_format($activeUsersTracked) }} active users</span>
    </div>

    <div class="activity-list">
        @forelse ($recentPageActivity as $activity)
            @php
                $name = trim(($activity->user->first_name ?? '') . ' ' . ($activity->user->last_name ?? ''));
                $name = $name !== '' ? $name : ($activity->user->email ?? 'User');
            @endphp
            <div class="activity-row">
                <div>
                    <div class="activity-name">{{ $name }}</div>
                    <div class="activity-meta">{{ $activity->path }}</div>
                </div>
                <div class="activity-meta">{{ $formatDuration((int) $activity->total_seconds) }}</div>
                <div class="activity-meta">{{ $activity->last_seen_at?->diffForHumans() ?? '-' }}</div>
            </div>
        @empty
            <div class="activity-row">
                <div class="activity-meta">No user activity captured yet.</div>
            </div>
        @endforelse
    </div>

    <hr>

    <div class="panel-header" style="margin-bottom: 0.8rem;">
        <h3 style="font-size:1rem;">Top users by portal time</h3>
    </div>
    <div class="activity-list">
        @forelse ($topUsersByTime as $item)
            @php
                $name = trim(($item->user->first_name ?? '') . ' ' . ($item->user->last_name ?? ''));
                $name = $name !== '' ? $name : ($item->user->email ?? 'User');
            @endphp
            <div class="activity-row">
                <div class="activity-name">{{ $name }}</div>
                <div class="activity-meta">{{ $formatDuration((int) $item->total_seconds) }}</div>
                <div class="activity-meta">{{ $item->last_seen_at ? \Illuminate\Support\Carbon::parse($item->last_seen_at)->diffForHumans() : '-' }}</div>
            </div>
        @empty
            <div class="activity-row">
                <div class="activity-meta">No usage leaderboard yet.</div>
            </div>
        @endforelse
    </div>
</div>
