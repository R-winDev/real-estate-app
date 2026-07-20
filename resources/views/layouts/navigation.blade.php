<nav x-data="{ open: false }" class="glass-strong sticky top-0 z-50 border-b border-white/20 shadow-soft">
    <div class="container-wide">
        <div class="flex justify-between h-16">
            <!-- Logo & Nav Links -->
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                        <x-application-logo class="h-8 w-auto text-brand-600 transition-transform duration-300 group-hover:scale-110" />
                        <span class="text-lg font-extrabold text-surface-900 hidden sm:inline tracking-tight">املاک</span>
                    </a>
                </div>

                <div class="hidden sm:flex sm:items-center sm:mr-10">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        صفحه اصلی
                    </x-nav-link>
                    <x-nav-link :href="route('properties.index')" :active="request()->routeIs('properties.*')">
                        املاک
                    </x-nav-link>
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            داشبورد
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            <!-- Right Side (User / Auth) -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium text-surface-600
                                           hover:bg-surface-100/80 hover:text-surface-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 transition-all duration-200">
                                <div class="w-9 h-9 bg-gradient-to-br from-brand-500 to-brand-600 rounded-xl flex items-center justify-center shadow-sm">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 text-surface-400 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                پروفایل
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    خروج
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-surface-600 hover:text-surface-900 ml-4 transition-colors duration-200">ورود</a>
                    <a href="{{ route('register') }}" class="btn-primary text-sm btn-sm">ثبت نام</a>
                @endauth
            </div>

            <!-- Mobile Hamburger -->
            <div class="-ml-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-surface-400
                                                       hover:text-surface-600 hover:bg-surface-100/80 focus:outline-none focus:ring-2 focus:ring-brand-500/20
                                                       transition-all duration-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
         class="hidden sm:hidden glass-strong border-t border-white/20">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                صفحه اصلی
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('properties.index')" :active="request()->routeIs('properties.*')">
                املاک
            </x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    داشبورد
                </x-responsive-nav-link>
            @endauth
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-surface-200/60">
                <div class="px-4">
                    <div class="font-medium text-base text-surface-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-surface-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1 px-4">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        پروفایل
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            خروج
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-surface-200/60 px-4 space-y-1">
                <x-responsive-nav-link :href="route('login')">
                    ورود
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">
                    ثبت نام
                </x-responsive-nav-link>
            </div>
        @endauth
    </div>
</nav>
