{{-- Sidebar: Fixed left on desktop, drawer on mobile (RTL: fixed-right) --}}
<aside x-cloak
       x-show="sidebarOpen"
       x-transition:enter="transition-transform duration-300 ease-out lg:transition-none"
       x-transition:enter-start="translate-x-full lg:translate-x-0"
       x-transition:enter-end="translate-x-0 lg:translate-x-0"
       x-transition:leave="transition-transform duration-200 ease-in"
       x-transition:leave-start="translate-x-0"
       x-transition:leave-end="translate-x-full"
       class="fixed inset-y-0 right-0 z-50 w-[240px] flex flex-col bg-primary-950 lg:!flex lg:translate-x-0">

    {{-- Brand --}}
    <div class="flex items-center gap-3 px-5 h-16 shrink-0 border-b border-white/[0.06]">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <div class="w-9 h-9 bg-primary-500 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-bold text-white leading-none">املاک</span>
                <span class="text-[10px] text-primary-400 mt-1">پنل مدیریت</span>
            </div>
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1 scrollbar-thin">
        @php
            $activeClass = 'bg-primary-500 text-white';
            $inactiveClass = 'text-primary-300/70 hover:text-white hover:bg-white/[0.06]';
        @endphp

        {{-- داشبورد --}}
        <a href="{{ route('admin.dashboard') }}" @click="sidebarOpen = false"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.dashboard') ? $activeClass : $inactiveClass }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
            </svg>
            داشبورد
        </a>

        {{-- ═══ املاک ═══ --}}
        <div class="pt-5 pb-2 px-3">
            <p class="text-[11px] font-bold text-primary-400/60 uppercase tracking-wider">املاک</p>
        </div>

        @php
            $propertyItems = [
                'property-types' => [
                    'label' => 'انواع ملک',
                    'icon' => 'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3H21m-3.75 3H21',
                ],
                'property-statuses' => [
                    'label' => 'وضعیت ملک',
                    'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                ],
            ];
        @endphp

        @foreach($propertyItems as $type => $config)
            <a href="{{ route('admin.lookup.index', $type) }}" @click="sidebarOpen = false"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.lookup.index') && request()->route('type') === $type ? $activeClass : $inactiveClass }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $config['icon'] }}"/>
                </svg>
                {{ $config['label'] }}
            </a>
        @endforeach

        {{-- ═══ مکان‌ها ═══ --}}
        <div class="pt-5 pb-2 px-3">
            <p class="text-[11px] font-bold text-primary-400/60 uppercase tracking-wider">مکان‌ها</p>
        </div>

        <a href="{{ route('admin.locations.index') }}" @click="sidebarOpen = false"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.locations.*') ? $activeClass : $inactiveClass }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
            </svg>
            موقعیت‌ها
        </a>

        {{-- ═══ امکانات و متریال ═══ --}}
        <div class="pt-5 pb-2 px-3">
            <p class="text-[11px] font-bold text-primary-400/60 uppercase tracking-wider">امکانات و متریال</p>
        </div>

        @php
            $materialItems = [
                'features' => [
                    'label' => 'امکانات',
                    'icon' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z',
                ],
                'climate-systems' => [
                    'label' => 'سیستم تهویه',
                    'icon' => 'M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z',
                ],
                'floor-materials' => [
                    'label' => 'متریال کف',
                    'icon' => 'M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z',
                ],
                'building-materials' => [
                    'label' => 'متریال ساختمان',
                    'icon' => 'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3H21m-3.75 3H21',
                ],
                'documents' => [
                    'label' => 'مدارک',
                    'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z',
                ],
            ];
        @endphp

        @foreach($materialItems as $type => $config)
            <a href="{{ route('admin.lookup.index', $type) }}" @click="sidebarOpen = false"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.lookup.index') && request()->route('type') === $type ? $activeClass : $inactiveClass }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $config['icon'] }}"/>
                </svg>
                {{ $config['label'] }}
            </a>
        @endforeach

        {{-- ═══ مدیریت ═══ --}}
        <div class="pt-5 pb-2 px-3">
            <p class="text-[11px] font-bold text-primary-400/60 uppercase tracking-wider">مدیریت</p>
        </div>

        <a href="{{ route('admin.users.index') }}" @click="sidebarOpen = false"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.users.*') ? $activeClass : $inactiveClass }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
            </svg>
            کاربران
        </a>

        @php
            $pendingCount = \App\Models\PropertyInquiry::where('status', 'pending')->count();
        @endphp
        <a href="{{ route('admin.inquiries.index') }}" @click="sidebarOpen = false"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.inquiries.*') ? $activeClass : $inactiveClass }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/>
            </svg>
            <span class="flex-1">درخواست‌ها</span>
            @if($pendingCount > 0)
                <span class="min-w-[20px] h-5 px-1.5 text-[10px] font-bold bg-danger text-white rounded-full flex items-center justify-center">{{ $pendingCount }}</span>
            @endif
        </a>

        {{-- ═══ عملیات ═══ --}}
        <div class="pt-5 pb-2 px-3">
            <p class="text-[11px] font-bold text-primary-400/60 uppercase tracking-wider">عملیات</p>
        </div>

        <a href="{{ route('properties.create') }}" @click="sidebarOpen = false"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('properties.create') ? $activeClass : $inactiveClass }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            ثبت ملک جدید
        </a>

        <a href="{{ route('properties.index') }}" @click="sidebarOpen = false"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('properties.index') ? $activeClass : $inactiveClass }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
            </svg>
            لیست املاک
        </a>
    </nav>

    {{-- User Info --}}
    <div class="shrink-0 border-t border-white/[0.06] px-4 py-4">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-primary-500 rounded-lg flex items-center justify-center shrink-0">
                <span class="text-white text-xs font-bold">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-[11px] text-primary-400 truncate" dir="ltr">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
</aside>
