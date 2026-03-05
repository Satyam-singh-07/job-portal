<div class="stats-grid">
    @foreach ($stats as $card)
        <div class="stat-card">
            <div class="stat-title"><i class="{{ $card['icon'] }}"></i> {{ $card['title'] }}</div>
            <div class="stat-value">{{ $card['value'] }}</div>
            <div class="stat-trend {{ $card['trend_down'] ? '' : 'neutral' }}">{{ $card['trend'] }} vs previous period</div>
        </div>
    @endforeach
</div>
