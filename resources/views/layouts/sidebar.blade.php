<aside id="sidebar" class="sidebar">

    {{-- ===== Header / Brand ===== --}}
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

        <button class="sidebar-collapse-btn d-none d-lg-flex" id="sidebarCollapseBtn" title="Collapse sidebar">
            <i class="bi bi-chevron-left"></i>
        </button>

    </div>

    <div class="sidebar-body">

        {{-- ===== Main Navigation ===== --}}
        <div class="nav-section">
            <span class="nav-section-label">Main</span>

            <ul class="nav flex-column">

                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="bi bi-grid-1x2-fill"></i></span>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('tasks.index') }}"
                       class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="bi bi-check2-square"></i></span>
                        <span class="nav-text">Tasks</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('focus.index') }}"
                       class="nav-link {{ request()->routeIs('focus.*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="bi bi-stopwatch-fill"></i></span>
                        <span class="nav-text">Focus Timer</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('remarks.index') }}"
                       class="nav-link {{ request()->routeIs('remarks.*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="bi bi-chat-left-text-fill"></i></span>
                        <span class="nav-text">Remarks</span>
                    </a>
                </li>

            </ul>
        </div>

        {{-- ===== Secondary Navigation ===== --}}
        <div class="nav-section">
            <span class="nav-section-label">Workspace</span>

            <ul class="nav flex-column">

                <li class="nav-item">
                    <a href="{{ route('notifications.index') }}"
                       class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="bi bi-bell-fill"></i></span>
                        <span class="nav-text">Notifications</span>

                        @php
                            $count = auth()->user()
                                ->notifications()
                                ->where('is_read', false)
                                ->count();
                        @endphp

                        @if($count)
                            <span class="nav-badge">{{ $count }}</span>
                        @endif
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('export.index') }}"
                       class="nav-link {{ request()->routeIs('export.*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="bi bi-download"></i></span>
                        <span class="nav-text">Export</span>
                    </a>
                </li>

            </ul>
        </div>

        {{-- ===== Productivity Widget ===== --}}
        <div class="nav-section">
            <span class="nav-section-label">Productivity</span>

            <div class="focus-card">

                <div class="focus-card-glow"></div>

                <div class="focus-icon">
                    <i class="bi bi-lightning-charge-fill"></i>
                </div>

                <h6 class="focus-title">Stay Focused</h6>

                <p class="focus-text">
                    Complete your most important task before moving to the next one.
                </p>

                <a href="{{ route('focus.index') }}" class="focus-btn">
                    <i class="bi bi-play-fill"></i>
                    Start Focus
                </a>

            </div>
        </div>

    </div>

    {{-- ===== Footer / Mini Profile ===== --}}
    <div class="sidebar-footer">
        <a href="#" class="sidebar-user">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6d5efc&color=fff&bold=true"
                 class="sidebar-user-avatar" alt="User">
            <div class="sidebar-user-info">
                <span class="sidebar-user-name">{{ auth()->user()->name }}</span>
                <span class="sidebar-user-role">View Profile</span>
            </div>
            <i class="bi bi-box-arrow-right sidebar-user-arrow"></i>
        </a>
    </div>

</aside>