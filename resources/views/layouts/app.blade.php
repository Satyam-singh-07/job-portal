<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Job Portal')</title>
    <meta name="description" content="@yield('meta_description', 'Find verified jobs, explore employers, and apply quickly with Job Portal.')">
    <meta name="robots" content="@yield('meta_robots', 'index,follow,max-snippet:-1,max-image-preview:large,max-video-preview:-1')">
    <link rel="canonical" href="@yield('canonical_url', url()->current())">

    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', trim($__env->yieldContent('title', 'Job Portal')))">
    <meta property="og:description" content="@yield('og_description', trim($__env->yieldContent('meta_description', 'Find verified jobs, explore employers, and apply quickly with Job Portal.')))">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:site_name" content="{{ config('app.name', 'Job Portal') }}">
    <meta property="og:image" content="@yield('og_image', asset('images/jobs-portal-logo.png'))">

    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:title" content="@yield('twitter_title', trim($__env->yieldContent('title', 'Job Portal')))">
    <meta name="twitter:description" content="@yield('twitter_description', trim($__env->yieldContent('meta_description', 'Find verified jobs, explore employers, and apply quickly with Job Portal.')))">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/jobs-portal-logo.png'))">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- CSS -->
    <link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    @yield('styles')
    @yield('head')
    @stack('structured_data')
</head>

<body>

    {{-- Header --}}
    @include('partials.header')

    {{-- Page Content --}}
    @yield('content')

    {{-- Footer --}}
    @include('partials.footer')

    <!-- JS -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>

    @auth
        <script>
            (function () {
                const endpoint = @json(route('activity.track'));
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                if (!endpoint || !token) return;

                let lastTrackedAt = Date.now();
                const currentPath = window.location.pathname + window.location.search;

                const sendPing = (seconds) => {
                    if (!seconds || seconds < 1) return;

                    const payload = {
                        path: currentPath,
                        seconds: Math.min(seconds, 120),
                        title: document.title || '',
                    };

                    fetch(endpoint, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        credentials: 'same-origin',
                        keepalive: true,
                        body: JSON.stringify(payload),
                    }).catch(() => {});
                };

                const flushElapsed = () => {
                    const now = Date.now();
                    const elapsed = Math.floor((now - lastTrackedAt) / 1000);
                    lastTrackedAt = now;
                    sendPing(elapsed);
                };

                const intervalRef = window.setInterval(flushElapsed, 15000);

                document.addEventListener('visibilitychange', () => {
                    if (document.visibilityState === 'hidden') {
                        flushElapsed();
                    } else {
                        lastTrackedAt = Date.now();
                    }
                });

                window.addEventListener('beforeunload', flushElapsed);
                window.addEventListener('pagehide', flushElapsed);

                window.__activityTrackerStop = () => {
                    clearInterval(intervalRef);
                };
            })();
        </script>
    @endauth

    @yield('scripts')


<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div id="liveToast" class="toast align-items-center text-white bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
</body>


<!-- Floating Notifications -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 2000;">
        @if(session('success'))
            <div class="toast align-items-center text-bg-success border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="toast text-bg-danger border-0 show">
                    <div class="d-flex">
                        <div class="toast-body">{{ $error }}</div>
                        <button type="button" class="btn-close btn-close-white m-auto me-2" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            @endforeach
        @endif
    </div>



</html>
