<aside id="sidebar" class="sidebar">

    {{-- ===== Header / Brand ===== --}}
    <div class="sidebar-header">

        <a href="{{ route('dashboard') }}" class="logo text-decoration-none">

            <div class="logo-icon">
                <i class="bi bi-lightning-charge-fill"></i>
            </div>

            <div class="logo-text">
                <h4 class="mb-0">Taskvel</h4>
                <small>कार्य, Done Well</small>
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
        {{-- ===================================================== --}}
        {{-- Client Management --}}
        {{-- ===================================================== --}}

        <hr class="my-4">

        <div class="nav-section">

            <span class="nav-section-label">

                Client Management

            </span>

            <ul class="nav flex-column">

                <li class="nav-item">

                    <a href="{{ route('clients.index') }}"
                    class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">

                        <span class="nav-icon">

                            <i class="bi bi-buildings-fill"></i>

                        </span>

                        <span class="nav-text">

                            Clients

                        </span>

                    </a>

                </li>

                <li class="nav-item">

                    <a href="{{ route('client-contacts.index') }}"
                    class="nav-link {{ request()->routeIs('client-contacts.*') ? 'active' : '' }}">

                        <span class="nav-icon">

                            <i class="bi bi-person-lines-fill"></i>

                        </span>

                        <span class="nav-text">

                            Contacts

                        </span>

                    </a>

                </li>

                <li class="nav-item">

                    <a href="{{ route('client-addresses.index') }}"
                    class="nav-link {{ request()->routeIs('client-addresses.*') ? 'active' : '' }}">

                        <span class="nav-icon">

                            <i class="bi bi-geo-alt-fill"></i>

                        </span>

                        <span class="nav-text">

                            Addresses

                        </span>

                    </a>

                </li>

                <li class="nav-item">

                    <a href="{{ route('client-services.index') }}"
                    class="nav-link {{ request()->routeIs('client-services.*') ? 'active' : '' }}">

                        <span class="nav-icon">

                            <i class="bi bi-briefcase-fill"></i>

                        </span>

                        <span class="nav-text">

                            Services

                        </span>

                    </a>

                </li>

                <li class="nav-item">

                    <a href="{{ route('client-documents.index') }}"
                    class="nav-link {{ request()->routeIs('client-documents.*') ? 'active' : '' }}">

                        <span class="nav-icon">

                            <i class="bi bi-folder-fill"></i>

                        </span>

                        <span class="nav-text">

                            Documents

                        </span>

                    </a>

                </li>

                <li class="nav-item">

                    <a href="{{ route('client-credentials.index') }}"
                    class="nav-link {{ request()->routeIs('client-credentials.*') ? 'active' : '' }}">

                        <span class="nav-icon">

                            <i class="bi bi-key-fill"></i>

                        </span>

                        <span class="nav-text">

                            Credentials

                        </span>

                    </a>

                </li>

                <li class="nav-item">

                    <a href="{{ route('client-remarks.index') }}"
                    class="nav-link {{ request()->routeIs('client-remarks.*') ? 'active' : '' }}">

                        <span class="nav-icon">

                            <i class="bi bi-chat-square-text-fill"></i>

                        </span>

                        <span class="nav-text">

                            Client Remarks

                        </span>

                    </a>

                </li>

                <li class="nav-item">

                    <a href="{{ route('client-communications.index') }}"
                    class="nav-link {{ request()->routeIs('client-communications.*') ? 'active' : '' }}">

                        <span class="nav-icon">

                            <i class="bi bi-envelope-fill"></i>

                        </span>

                        <span class="nav-text">

                            Communications

                        </span>

                    </a>

                </li>

                <li class="nav-item">

                    <a href="{{ route('client-tags.index') }}"
                    class="nav-link {{ request()->routeIs('client-tags.*') ? 'active' : '' }}">

                        <span class="nav-icon">

                            <i class="bi bi-tags-fill"></i>

                        </span>

                        <span class="nav-text">

                            Client Tags

                        </span>

                    </a>

                </li>
                <li class="nav-item">

                <a href="{{ route('chat.index') }}"
                class="nav-link {{ request()->routeIs('chat.*') ? 'active' : '' }} position-relative">

                    {{-- ICON --}}
                    <span class="nav-icon">
                        <i class="bi bi-chat-dots-fill"></i>
                    </span>

                    {{-- TEXT --}}
                    <span class="nav-text">
                        Messages
                    </span>

                    {{-- UNREAD BADGE --}}
                    @php
                        $chatUnread = \App\Models\Message::whereHas('conversation', function($q) {
                            $q->where('user_id', auth()->id())
                            ->orWhere('admin_id', auth()->id());
                        })
                        ->whereNull('read_at')
                        ->where('sender_id', '!=', auth()->id())
                        ->count();
                    @endphp

                    @if($chatUnread > 0)
                        <span class="nav-badge bg-danger">
                            {{ $chatUnread }}
                        </span>
                    @endif

                    {{-- LIVE DOT --}}
                    <span class="chat-live-dot"></span>

                </a>

            </li>
            <li class="nav-item">
                <a href="#" class="nav-link {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
                    {{-- ICON --}}
                    <span class="nav-icon">
                        <i class="bi bi-shield-lock-fill"></i>
                    </span>

                    {{-- TEXT --}}
                    <span class="nav-text">
                        Permissions
                    </span>

                    {{-- ARROW ICON --}}
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>

                {{-- SUBMENU --}}
                <ul class="nav-submenu {{ request()->routeIs('permissions.*') ? 'show' : '' }}">
                    <li class="nav-item">
                        <a href="{{ route('permissions.index') }}" class="nav-link {{ request()->routeIs('permissions.index') ? 'active' : '' }}">
                            <i class="bi bi-circle nav-icon"></i>
                            <span class="nav-text">All Permissions</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('permissions.assign') }}" class="nav-link {{ request()->routeIs('permissions.assign') ? 'active' : '' }}">
                            <i class="bi bi-circle nav-icon"></i>
                            <span class="nav-text">Assign Permissions</span>
                        </a>
                    </li>
                </ul>
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