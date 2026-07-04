<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>

    {{-- ===== Core Meta ===== --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#6d5efc">

    <title>@yield('title', 'Taskvel — कार्य, Done Well')</title>
    <meta name="description" content="@yield('meta_description', 'Taskvel - Premium Productivity & Task Management')">

    {{-- ===== Favicon ===== --}}
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/favicon.png') }}">

    {{-- ===== Preconnect (perf) ===== --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">

    {{-- ===== Fonts ===== --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- ===== Vendor CSS ===== --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

    {{-- ===== App CSS ===== --}}
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">

    @stack('styles')
    <style>
        .chat-live-dot {
    width: 8px;
    height: 8px;
    background: #22c55e;
    border-radius: 50%;
    position: absolute;
    right: 38px;
    top: 50%;
    transform: translateY(-50%);
    box-shadow: 0 0 10px rgba(34,197,94,0.8);
    animation: pulseDot 1.5s infinite;
}

@keyframes pulseDot {
    0% {
        transform: translateY(-50%) scale(1);
        opacity: 1;
    }
    50% {
        transform: translateY(-50%) scale(1.4);
        opacity: 0.6;
    }
    100% {
        transform: translateY(-50%) scale(1);
        opacity: 1;
    }
}
</style>

</head>

<body>

    {{-- ===== Page Loader ===== --}}
    <div id="pageLoader" class="page-loader">
        <div class="loader-ring"></div>
    </div>

    <div id="app">

        @include('layouts.sidebar')

        <div class="main-wrapper">

            @include('layouts.navbar')

            <main class="container-fluid py-4 content-area">

                {{-- ===== Flash Messages ===== --}}
                @if(session('success'))
                    <div class="alert alert-success premium-alert alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger premium-alert alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- ===== Page Content ===== --}}
                @yield('content')

            </main>

            @include('layouts.footer')

        </div>

    </div>

    {{-- ===== Vendor JS ===== --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@4.7.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/countup.js@2.9.0/dist/countUp.umd.min.js"></script>

    {{-- ===== App JS ===== --}}
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/task.js') }}"></script>
    <script src="{{ asset('assets/js/focus.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="{{ asset('assets/js/sidebar.js') }}"></script>

    {{-- ===== Init ===== --}}
    <script>
        AOS.init({ once: true, duration: 700, easing: 'ease-out-cubic' });

        window.addEventListener('load', function () {
            const loader = document.getElementById('pageLoader');
            if (loader) {
                loader.classList.add('loaded');
                setTimeout(() => loader.remove(), 400);
            }
        });
    </script>

    @stack('scripts')

</body>
</html>