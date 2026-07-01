<nav class="navbar navbar-expand-lg premium-navbar sticky-top px-4" id="mainNavbar">

    <div class="container-fluid">

        <!-- Mobile Sidebar Toggle -->
        <button class="btn btn-icon d-lg-none me-3" id="sidebarToggle">
            <i class="bi bi-list fs-4"></i>
        </button>

        <!-- Brand (mobile only, optional) -->
        <a href="{{ url('/') }}" class="navbar-brand d-lg-none fw-bold me-3">
            <span class="brand-gradient">Taskvel</span>
        </a>

        <!-- Search -->
        <div class="d-none d-md-flex align-items-center flex-grow-1 me-4">

            <div class="position-relative w-100 premium-search" style="max-width:440px;">

                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                <input
                    type="search"
                    class="form-control rounded-pill ps-5 pe-4"
                    placeholder="Search tasks, remarks, tags...">

                <kbd class="search-kbd position-absolute top-50 end-0 translate-middle-y me-3 d-none d-lg-inline-flex">⌘K</kbd>

            </div>

        </div>

        <ul class="navbar-nav ms-auto align-items-center gap-1">

            <!-- Theme Toggle -->
            <li class="nav-item">

                <button
                    class="btn btn-icon"
                    id="themeToggle"
                    title="Toggle Theme">

                    <i class="bi bi-moon-stars"></i>

                </button>

            </li>

            <!-- Divider -->
            <li class="nav-item d-none d-md-block">
                <div class="navbar-divider mx-2"></div>
            </li>

            <!-- Notifications -->
            <li class="nav-item dropdown">

                <a class="btn btn-icon position-relative"
                   href="#"
                   data-bs-toggle="dropdown">

                    <i class="bi bi-bell fs-5"></i>

                    @php
                        $notificationCount = auth()->check()
                            ? auth()->user()->notifications()->where('is_read', false)->count()
                            : 0;
                    @endphp

                    @if($notificationCount)

                        <span class="notif-dot">
                            <span class="notif-dot-ping"></span>
                        </span>

                    @endif

                </a>

                <div class="dropdown-menu dropdown-menu-end premium-dropdown p-0"
                     style="width:360px;">

                    <div class="d-flex align-items-center justify-content-between px-3 py-3 border-bottom">
                        <strong class="fs-6">Notifications</strong>
                        @if($notificationCount)
                            <span class="badge rounded-pill notif-count-badge">{{ $notificationCount }} new</span>
                        @endif
                    </div>

                    <div class="notif-list">

                        @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notification)

                            <a href="#" class="dropdown-item notif-item py-3 px-3">
                                <div class="d-flex gap-3">
                                    <div class="notif-icon">
                                        <i class="bi bi-bell-fill"></i>
                                    </div>
                                    <div class="flex-grow-1 min-w-0">
                                        <div class="fw-semibold text-truncate">
                                            {{ $notification->title }}
                                        </div>
                                        <small class="text-muted d-block text-truncate">
                                            {{ $notification->message }}
                                        </small>
                                    </div>
                                </div>
                            </a>

                        @empty

                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-bell-slash fs-2 d-block mb-2 opacity-50"></i>
                                No notifications available.
                            </div>

                        @endforelse

                    </div>

                    <div class="text-center border-top py-2">
                        <a href="#" class="small fw-semibold text-decoration-none">View all notifications</a>
                    </div>

                </div>

            </li>

            <!-- Divider -->
            <li class="nav-item d-none d-md-block">
                <div class="navbar-divider mx-2"></div>
            </li>

            <!-- User -->
            <li class="nav-item dropdown">

                <a class="nav-link dropdown-toggle d-flex align-items-center user-toggle"
                   href="#"
                   data-bs-toggle="dropdown">

                    <div class="avatar-ring">
                        <img
                            src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6d5efc&color=fff&bold=true"
                            width="38"
                            height="38"
                            class="rounded-circle"
                            alt="User">
                        <span class="online-dot"></span>
                    </div>

                    <div class="d-none d-lg-block ms-2 text-start">

                        <div class="fw-semibold lh-1 mb-1">
                            {{ auth()->user()->name }}
                        </div>

                        <small class="text-muted lh-1">
                            {{ auth()->user()->email }}
                        </small>

                    </div>

                </a>

                <ul class="dropdown-menu dropdown-menu-end premium-dropdown p-2" style="width:230px;">

                    <li class="px-2 py-2 d-lg-none border-bottom mb-2">
                        <div class="fw-semibold">{{ auth()->user()->name }}</div>
                        <small class="text-muted">{{ auth()->user()->email }}</small>
                    </li>

                    <li>

                        <a class="dropdown-item premium-item" href="#">

                            <i class="bi bi-person"></i>
                            Profile

                        </a>

                    </li>

                    <li>

                        <a class="dropdown-item premium-item" href="#">

                            <i class="bi bi-gear"></i>
                            Settings

                        </a>

                    </li>

                    <li><hr class="dropdown-divider my-2"></li>

                    <li>

                        <form method="POST" action="{{ route('logout') }}">

                            @csrf

                            <button class="dropdown-item premium-item text-danger">

                                <i class="bi bi-box-arrow-right"></i>
                                Logout

                            </button>

                        </form>

                    </li>

                </ul>

            </li>

        </ul>

    </div>

</nav>

<style>
    .premium-navbar {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border-bottom: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 4px 24px rgba(17, 12, 46, 0.04);
        transition: box-shadow .25s ease;
        height: 72px;
    }
    .premium-navbar.scrolled {
        box-shadow: 0 8px 28px rgba(17, 12, 46, 0.08);
    }

    .brand-gradient {
        background: linear-gradient(135deg, #6d5efc, #a06dfc);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .btn-icon {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: 1px solid transparent;
        background: rgba(109, 94, 252, 0.06);
        color: #4b4b5a;
        transition: all .2s ease;
    }
    .btn-icon:hover {
        background: rgba(109, 94, 252, 0.14);
        color: #6d5efc;
        transform: translateY(-1px);
    }

    .navbar-divider {
        width: 1px;
        height: 24px;
        background: rgba(0,0,0,0.08);
    }

    .premium-search .form-control {
        border: 1px solid rgba(0,0,0,0.08);
        background: #f6f6fb;
        font-size: .9rem;
        transition: all .2s ease;
    }
    .premium-search .form-control:focus {
        background: #fff;
        border-color: #6d5efc;
        box-shadow: 0 0 0 4px rgba(109, 94, 252, 0.12);
    }
    .search-kbd {
        font-size: .7rem;
        padding: 2px 6px;
        border-radius: 5px;
        background: #fff;
        border: 1px solid rgba(0,0,0,0.08);
        color: #8a8a9a;
        pointer-events: none;
    }

    .notif-dot {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #ff4d6d;
        display: inline-block;
    }
    .notif-dot-ping {
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: #ff4d6d;
        animation: ping 1.6s cubic-bezier(0,0,0.2,1) infinite;
    }
    @keyframes ping {
        75%, 100% { transform: scale(2.4); opacity: 0; }
    }

    .premium-dropdown {
        border: none;
        border-radius: 16px;
        box-shadow: 0 16px 48px rgba(17, 12, 46, 0.14);
        margin-top: 12px;
        overflow: hidden;
        animation: dropdownFade .18s ease;
    }
    @keyframes dropdownFade {
        from { opacity: 0; transform: translateY(-6px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .notif-list { max-height: 320px; overflow-y: auto; }
    .notif-item { transition: background .15s ease; }
    .notif-item:hover { background: rgba(109, 94, 252, 0.06); }
    .notif-icon {
        width: 38px;
        height: 38px;
        flex-shrink: 0;
        border-radius: 50%;
        background: linear-gradient(135deg, #6d5efc, #a06dfc);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .85rem;
    }
    .notif-count-badge {
        background: rgba(109, 94, 252, 0.12);
        color: #6d5efc;
        font-size: .7rem;
        font-weight: 600;
    }

    .avatar-ring {
        position: relative;
        padding: 2px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6d5efc, #a06dfc);
    }
    .avatar-ring img { display: block; border: 2px solid #fff; }
    .online-dot {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 11px;
        height: 11px;
        background: #2ecc71;
        border: 2px solid #fff;
        border-radius: 50%;
    }

    .user-toggle::after { display: none; }
    .user-toggle { padding: 4px 8px; border-radius: 12px; transition: background .2s ease; }
    .user-toggle:hover { background: rgba(109, 94, 252, 0.06); }

    .premium-item {
        display: flex;
        align-items: center;
        gap: 10px;
        border-radius: 10px;
        padding: 8px 10px;
        font-size: .9rem;
        transition: all .15s ease;
    }
    .premium-item:hover {
        background: rgba(109, 94, 252, 0.08);
        color: #6d5efc;
        transform: translateX(2px);
    }
    .premium-item i { font-size: 1rem; width: 18px; }

    [data-bs-theme="dark"] .premium-navbar {
        background: rgba(20, 20, 30, 0.85);
        border-bottom-color: rgba(255,255,255,0.06);
    }
    [data-bs-theme="dark"] .premium-search .form-control {
        background: #1c1c28;
        border-color: rgba(255,255,255,0.08);
        color: #e4e4ec;
    }
    [data-bs-theme="dark"] .premium-dropdown { background: #1c1c28; color: #e4e4ec; }
    [data-bs-theme="dark"] .btn-icon { color: #d0d0da; }
</style>

<script>
    window.addEventListener('scroll', function () {
        document.getElementById('mainNavbar').classList.toggle('scrolled', window.scrollY > 8);
    });
</script>