<div class="actions">
    @foreach ($quickActions as $action)
        <a class="action-btn" href="{{ $action['url'] }}">
            <i class="{{ $action['icon'] }}"></i>
            {{ $action['label'] }}
        </a>
    @endforeach
</div>
