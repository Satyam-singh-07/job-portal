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

            @include('admin.settings.components.header', ['admin' => auth()->user()])
            @include('admin.settings.components.stat-cards', ['stats' => $stats])
            @include('admin.settings.components.defaults-form', ['defaults' => $defaults])
            @include('admin.settings.components.low-balance-tables', [
                'lowBalanceCandidates' => $lowBalanceCandidates,
                'lowBalanceEmployers' => $lowBalanceEmployers,
            ])
        </main>
    </div>
</body>
</html>
