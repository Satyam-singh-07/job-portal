<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Job Portal')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- CSS -->
    <link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    @stack('styles')
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
