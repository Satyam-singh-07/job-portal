<div class="stats-grid">
    @foreach ($statCards as $card)
        <div class="stat-card">
            <div class="stat-title"><i class="{{ $card['icon'] }}"></i> {{ $card['title'] }}</div>
            <div class="stat-value">{{ $card['value'] }}</div>
            <div class="stat-trend {{ !empty($card['trend_neutral']) ? 'neutral' : '' }}">
                <i class="fas {{ !empty($card['trend_neutral']) ? 'fa-minus' : 'fa-arrow-up' }}"></i>
                {{ $card['trend'] }}
            </div>
        </div>
    @endforeach
</div>
