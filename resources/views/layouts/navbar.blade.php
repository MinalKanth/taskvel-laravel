<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm sticky-top px-4">

    <div class="container-fluid">

        <!-- Mobile Sidebar Toggle -->
        <button class="btn btn-outline-primary d-lg-none me-3" id="sidebarToggle">
            <i class="bi bi-list fs-4"></i>
        </button>

        <!-- Search -->
        <div class="d-none d-md-flex align-items-center flex-grow-1 me-4">

            <div class="position-relative w-100" style="max-width:420px;">

                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                <input
                    type="search"
                    class="form-control rounded-pill ps-5"
                    placeholder="Search tasks, remarks, tags...">

            </div>

        </div>

        <ul class="navbar-nav ms-auto align-items-center">

            <!-- Theme Toggle -->
            <li class="nav-item me-2">

                <button
                    class="btn btn-light rounded-circle"
                    id="themeToggle"
                    title="Toggle Theme">

                    <i class="bi bi-moon-stars"></i>

                </button>

            </li>

            <!-- Notifications -->
            <li class="nav-item dropdown me-3">

                <a class="nav-link position-relative"
                   href="#"
                   data-bs-toggle="dropdown">

                    <i class="bi bi-bell fs-5"></i>

                    @php
                        $notificationCount = auth()->check()
                            ? auth()->user()->notifications()->where('is_read', false)->count()
                            : 0;
                    @endphp

                    @if($notificationCount)

                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">

                            {{ $notificationCount }}

                        </span>

                    @endif

                </a>

                <div class="dropdown-menu dropdown-menu-end shadow border-0 p-0"
                     style="width:340px;">

                    <div class="border-bottom px-3 py-2">

                        <strong>Notifications</strong>

                    </div>

                    @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notification)

                        <a href="#"
                           class="dropdown-item py-3">

                            <div class="fw-semibold">

                                {{ $notification->title }}

                            </div>

                            <small class="text-muted">

                                {{ $notification->message }}

                            </small>

                        </a>

                    @empty

                        <div class="text-center py-4 text-muted">

                            No notifications available.

                        </div>

                    @endforelse

                </div>

            </li>

            <!-- User -->
            <li class="nav-item dropdown">

                <a class="nav-link dropdown-toggle d-flex align-items-center"
                   href="#"
                   data-bs-toggle="dropdown">

                    <img
                        src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}"
                        width="40"
                        height="40"
                        class="rounded-circle border me-2"
                        alt="User">

                    <div class="d-none d-lg-block">

                        <div class="fw-semibold">

                            {{ auth()->user()->name }}

                        </div>

                        <small class="text-muted">

                            {{ auth()->user()->email }}

                        </small>

                    </div>

                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow">

                    <li>

                        <a class="dropdown-item" href="#">

                            <i class="bi bi-person me-2"></i>

                            Profile

                        </a>

                    </li>

                    <li>

                        <a class="dropdown-item" href="#">

                            <i class="bi bi-gear me-2"></i>

                            Settings

                        </a>

                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>

                        <form method="POST" action="{{ route('logout') }}">

                            @csrf

                            <button class="dropdown-item text-danger">

                                <i class="bi bi-box-arrow-right me-2"></i>

                                Logout

                            </button>

                        </form>

                    </li>

                </ul>

            </li>

        </ul>

    </div>

</nav>