<aside id="sidebar" class="sidebar">

    <div class="sidebar-header">

        <a href="{{ route('dashboard') }}" class="logo text-decoration-none">

            <div class="logo-icon">
                <i class="bi bi-lightning-charge-fill"></i>
            </div>

            <div class="logo-text">

                <h4 class="mb-0">Taskvel</h4>

                <small>Productivity Suite</small>

            </div>

        </a>

    </div>

    <div class="sidebar-body">

        <ul class="nav flex-column">

            <li class="nav-item">
                <a href="{{ route('dashboard') }}"
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('tasks.index') }}"
                   class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                    <i class="bi bi-check2-square"></i>
                    <span>Tasks</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('focus.index') }}"
                   class="nav-link {{ request()->routeIs('focus.*') ? 'active' : '' }}">
                    <i class="bi bi-stopwatch-fill"></i>
                    <span>Focus Timer</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('remarks.index') }}"
                   class="nav-link {{ request()->routeIs('remarks.*') ? 'active' : '' }}">
                    <i class="bi bi-chat-left-text-fill"></i>
                    <span>Remarks</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('notifications.index') }}"
                   class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                    <i class="bi bi-bell-fill"></i>
                    <span>Notifications</span>

                    @php
                        $count = auth()->user()
                            ->notifications()
                            ->where('is_read', false)
                            ->count();
                    @endphp

                    @if($count)

                        <span class="badge bg-danger ms-auto">

                            {{ $count }}

                        </span>

                    @endif

                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('export.index') }}"
                   class="nav-link {{ request()->routeIs('export.*') ? 'active' : '' }}">
                    <i class="bi bi-download"></i>
                    <span>Export</span>
                </a>
            </li>

        </ul>

        <hr>

        <div class="px-3">

            <h6 class="text-uppercase text-muted small mb-3">

                Productivity

            </h6>

            <div class="card shadow-sm border-0">

                <div class="card-body text-center">

                    <div class="display-6 text-primary">

                        <i class="bi bi-lightning-charge-fill"></i>

                    </div>

                    <h6 class="mt-3">

                        Stay Focused

                    </h6>

                    <p class="small text-muted mb-3">

                        Complete your most important task before moving to the next one.

                    </p>

                    <a href="{{ route('focus.index') }}"
                       class="btn btn-primary btn-sm w-100">

                        Start Focus

                    </a>

                </div>

            </div>

        </div>

    </div>

</aside>