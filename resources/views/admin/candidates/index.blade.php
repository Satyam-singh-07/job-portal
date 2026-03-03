<!DOCTYPE html>
<html lang="en">
@include('admin.components.styles')
<body>
    <div class="dashboard">
        @include('admin.components.sidebar', ['stats' => $sidebarStats])

        <main class="main">
            @if (session('success'))
                <div style="background:#e8f6ed;border:1px solid #cbe9d5;color:#1f6e3f;padding:.7rem 1rem;border-radius:14px;font-size:.86rem;">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background:#fdeeee;border:1px solid #f5cece;color:#a93030;padding:.7rem 1rem;border-radius:14px;font-size:.86rem;">
                    {{ $errors->first() }}
                </div>
            @endif

            @include('admin.candidates.components.header', ['admin' => auth()->user()])
            @include('admin.candidates.components.stat-cards', ['stats' => $stats])
            @include('admin.candidates.components.filters', [
                'filters' => $filters,
                'experienceLevels' => $experienceLevels,
                'workPreferences' => $workPreferences,
            ])
            @include('admin.candidates.components.table', ['candidates' => $candidates])
        </main>
    </div>
</body>
</html>
