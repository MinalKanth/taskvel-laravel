<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between h-16">

            <!-- Left -->

            <div class="flex">

                <!-- Logo -->

                <div class="shrink-0 flex items-center">

                    <a href="{{ route('dashboard') }}">

                        <x-application-logo class="block h-9 w-auto fill-current text-indigo-600"/>

                    </a>

                </div>

                <!-- Desktop Navigation -->

                <div class="hidden sm:flex sm:items-center sm:space-x-8 sm:ms-10">

                    <x-nav-link
                        :href="route('dashboard')"
                        :active="request()->routeIs('dashboard')">

                        Dashboard

                    </x-nav-link>

                    <x-nav-link
                        :href="route('tasks.index')"
                        :active="request()->routeIs('tasks.*')">

                        Tasks

                    </x-nav-link>

                    <x-nav-link
                        :href="route('remarks.index')"
                        :active="request()->routeIs('remarks.*')">

                        Remarks

                    </x-nav-link>

                    <x-nav-link
                        :href="route('focus.index')"
                        :active="request()->routeIs('focus.*')">

                        Focus

                    </x-nav-link>

                    <x-nav-link
                        :href="route('export.index')"
                        :active="request()->routeIs('export.*')">

                        Export

                    </x-nav-link>

                    <x-nav-link
                        :href="route('notifications.index')"
                        :active="request()->routeIs('notifications.*')">

                        Notifications

                        @if(($unreadNotifications ?? 0) > 0)

                            <span class="ml-1 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold text-white bg-red-600 rounded-full">

                                {{ $unreadNotifications }}

                            </span>

                        @endif

                    </x-nav-link>

                </div>

            </div>

            <!-- Right -->

            <div class="hidden sm:flex sm:items-center sm:space-x-4">

                <!-- Theme Button -->

                <form method="POST"
                      action="{{ route('theme.toggle') }}">

                    @csrf

                    <button
                        class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition">

                        🌙

                    </button>

                </form>

                <!-- User Dropdown -->

                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">

                        <button class="inline-flex items-center px-3 py-2 border border-transparent rounded-md text-sm font-medium text-gray-600 bg-white hover:text-gray-900">

                            <div>

                                {{ Auth::user()->name }}

                            </div>

                            <div class="ms-1">

                                <svg class="fill-current h-4 w-4"
                                     viewBox="0 0 20 20">

                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd"/>

                                </svg>

                            </div>

                        </button>

                    </x-slot>

                    <x-slot name="content">

                        <x-dropdown-link
                            :href="route('profile.edit')">

                            Profile

                        </x-dropdown-link>

                        <form method="POST"
                              action="{{ route('logout') }}">

                            @csrf

                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">

                                Logout

                            </x-dropdown-link>

                        </form>

                    </x-slot>

                </x-dropdown>

            </div>

            <!-- Mobile Button -->

            <div class="-me-2 flex items-center sm:hidden">

                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:bg-gray-100">

                    <svg class="h-6 w-6"
                         stroke="currentColor"
                         fill="none"
                         viewBox="0 0 24 24">

                        <path :class="{ 'hidden': open, 'inline-flex': !open }"
                              class="inline-flex"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>

                        <path :class="{ 'hidden': !open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>

                    </svg>

                </button>

            </div>

        </div>

    </div>

    <!-- Mobile Navigation -->

    <div :class="{ 'block': open, 'hidden': !open }"
         class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link
                :href="route('dashboard')"
                :active="request()->routeIs('dashboard')">

                Dashboard

            </x-responsive-nav-link>

            <x-responsive-nav-link
                :href="route('tasks.index')"
                :active="request()->routeIs('tasks.*')">

                Tasks

            </x-responsive-nav-link>

            <x-responsive-nav-link
                :href="route('remarks.index')"
                :active="request()->routeIs('remarks.*')">

                Remarks

            </x-responsive-nav-link>

            <x-responsive-nav-link
                :href="route('focus.index')"
                :active="request()->routeIs('focus.*')">

                Focus

            </x-responsive-nav-link>

            <x-responsive-nav-link
                :href="route('export.index')"
                :active="request()->routeIs('export.*')">

                Export

            </x-responsive-nav-link>

            <x-responsive-nav-link
                :href="route('notifications.index')"
                :active="request()->routeIs('notifications.*')">

                Notifications

            </x-responsive-nav-link>

        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">

            <div class="px-4">

                <div class="font-medium text-base text-gray-800">

                    {{ Auth::user()->name }}

                </div>

                <div class="font-medium text-sm text-gray-500">

                    {{ Auth::user()->email }}

                </div>

            </div>

            <div class="mt-3 space-y-1">

                <x-responsive-nav-link
                    :href="route('profile.edit')">

                    Profile

                </x-responsive-nav-link>

                <form method="POST"
                      action="{{ route('logout') }}">

                    @csrf

                    <x-responsive-nav-link
                        :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">

                        Logout

                    </x-responsive-nav-link>

                </form>

            </div>

        </div>

    </div>

</nav>