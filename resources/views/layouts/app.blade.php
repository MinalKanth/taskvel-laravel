<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>

    {{-- ===== Core Meta ===== --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#6d5efc">

    <title>@yield('title', 'Taskvel — Premium Task Management')</title>
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
<style>
    /* ============ LAYOUT FIX ============ */

/* Sidebar stays fixed */
.sidebar {
    width: 268px;
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    z-index: 1030;
}

/* Push main content beside the sidebar, not under it */
.main-wrapper {
    margin-left: 268px;
    min-height: 100vh;
    width: calc(100% - 268px);
    transition: margin-left .25s ease, width .25s ease;
    box-sizing: border-box;
}

/* When sidebar is collapsed */
.sidebar.collapsed {
    width: 82px;
}
.main-wrapper.sidebar-collapsed {
    margin-left: 82px;
    width: calc(100% - 82px);
}

/* Navbar inside main-wrapper should span full width of remaining space */
.premium-navbar {
    width: 100%;
}

/* Mobile: sidebar becomes an overlay drawer, content takes full width */
@media (max-width: 991.98px) {
    .sidebar {
        transform: translateX(-100%);
    }
    .sidebar.show {
        transform: translateX(0);
    }
    .main-wrapper,
    .main-wrapper.sidebar-collapsed {
        margin-left: 0;
        width: 100%;
    }
}
</style>
    @stack('styles')

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