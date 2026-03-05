@php
    $periodTotal = (int) collect($dailySeries)->sum('count');
    $peak = collect($dailySeries)->sortByDesc('count')->first();
@endphp

<div class="panel">
    <div class="panel-header">
        <h3>Daily Activity Trend</h3>
        <div class="muted">{{ count($dailySeries) }} days</div>
    </div>

    <div style="display:flex;align-items:flex-end;gap:.5rem;height:180px;">
        @foreach ($dailySeries as $point)
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:.3rem;">
                <div style="width:100%;height:155px;background:#eaf0fe;border-radius:10px;position:relative;">
                    <div style="position:absolute;left:0;right:0;bottom:0;height:{{ max((int) $point['height'], 2) }}px;background:#2f57b3;border-radius:10px;"></div>
                </div>
                <div class="muted" style="font-size:.68rem;">{{ $point['label'] }}</div>
            </div>
        @endforeach
    </div>

    <div class="legend">
        <span>Total views: {{ number_format($periodTotal) }}</span>
        <span>
            Peak: {{ number_format((int) ($peak['count'] ?? 0)) }}
            @if (!empty($peak))
                ({{ $peak['label'] }})
            @endif
        </span>
    </div>
</div>
