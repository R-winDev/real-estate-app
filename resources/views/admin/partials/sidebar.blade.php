<div @click="sidebarOpen = false" x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-black/40 backdrop-blur-sm lg:hidden" x-cloak></div>

<aside x-show="sidebarOpen" x-cloak class="relative w-64 bg-surface-900 text-white flex flex-col shrink-0 z-50 lg:!flex lg:z-auto transition-all duration-300">
    <div class="flex items-center gap-3 px-5 h-16 border-b border-white/5">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5">
            <div class="w-8 h-8 bg-brand-500 rounded-lg flex items-center justify-center shadow-lg shadow-brand-500/30">
                <svg class="w-4.5 h-4.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </div>
            <div>
                <span class="text-sm font-extrabold text-white leading-none block">املاک</span>
                <span class="text-[10px] text-surface-500 font-medium">پنل مدیریت</span>
            </div>
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-0.5 scrollbar-thin">
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-surface-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            داشبورد
        </a>

        <div class="pt-5 pb-2 px-3">
            <p class="text-[10px] font-bold text-surface-500 uppercase tracking-widest">املاک</p>
        </div>

        @php
            $lookupTypes = [
                'property-types' => ['label' => 'انواع ملک', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>'],
                'property-statuses' => ['label' => 'وضعیت ملک', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
            ];
        @endphp

        @foreach($lookupTypes as $type => $config)
            <a href="{{ route('admin.lookup.index', $type) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('admin.lookup.index') && request()->route('type') === $type ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-surface-400 hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $config['icon'] !!}</svg>
                {{ $config['label'] }}
            </a>
        @endforeach

        <div class="pt-5 pb-2 px-3">
            <p class="text-[10px] font-bold text-surface-500 uppercase tracking-widest">مکان‌ها</p>
        </div>

        <a href="{{ route('admin.locations.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('admin.locations.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-surface-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            موقعیت‌ها
        </a>

        <div class="pt-5 pb-2 px-3">
            <p class="text-[10px] font-bold text-surface-500 uppercase tracking-widest">امکانات و متریال</p>
        </div>

        @php
            $materialTypes = [
                'features' => ['label' => 'امکانات', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'],
                'climate-systems' => ['label' => 'سیستم تهویه', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>'],
                'floor-materials' => ['label' => 'متریال کف', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm0 8a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1v-2zm0 8a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1v-2z"/>'],
                'building-materials' => ['label' => 'متریال ساختمان', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>'],
                'documents' => ['label' => 'مدارک', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
            ];
        @endphp

        @foreach($materialTypes as $type => $config)
            <a href="{{ route('admin.lookup.index', $type) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('admin.lookup.index') && request()->route('type') === $type ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-surface-400 hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $config['icon'] !!}</svg>
                {{ $config['label'] }}
            </a>
        @endforeach

        <div class="pt-5 pb-2 px-3">
            <p class="text-[10px] font-bold text-surface-500 uppercase tracking-widest">مدیریت</p>
        </div>

        <a href="{{ route('admin.users.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-surface-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            کاربران
        </a>

        <a href="{{ route('admin.inquiries.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('admin.inquiries.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-surface-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            <span class="flex-1">درخواست‌ها</span>
            @php
                $pendingCount = \App\Models\PropertyInquiry::where('status', 'pending')->count();
            @endphp
            @if($pendingCount > 0)
                <span class="min-w-[20px] h-5 px-1.5 text-[10px] font-bold bg-red-500 text-white rounded-full flex items-center justify-center">{{ $pendingCount }}</span>
            @endif
        </a>

        <div class="pt-5 pb-2 px-3">
            <p class="text-[10px] font-bold text-surface-500 uppercase tracking-widest">عملیات</p>
        </div>

        <a href="{{ route('properties.create') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('properties.create') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-surface-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            ثبت ملک جدید
        </a>

        <a href="{{ route('properties.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('properties.index') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-surface-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
            لیست املاک
        </a>
    </nav>

    <div class="border-t border-white/5 px-4 py-4 mt-auto">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-gradient-to-br from-brand-400 to-brand-600 rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-brand-500/20">
                <span class="text-white text-xs font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-[11px] text-surface-500 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
</aside>
