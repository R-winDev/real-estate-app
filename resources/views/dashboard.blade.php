<x-admin-layout title="داشبورد">
    <div class="space-y-6">

        {{-- Welcome Banner --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-l from-brand-600 via-brand-700 to-brand-800 p-6 sm:p-8">
            <div class="absolute -top-16 -left-16 w-48 h-48 bg-white/[0.06] rounded-full blur-2xl"></div>
            <div class="absolute -bottom-16 -right-16 w-40 h-40 bg-white/[0.06] rounded-full blur-2xl"></div>
            <div class="absolute top-0 right-0 w-full h-full opacity-[0.04]" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
            <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-2xl">&#128075;</span>
                        <h3 class="text-xl sm:text-2xl font-extrabold text-white">خوش آمدید، {{ Auth::user()->name }}!</h3>
                    </div>
                    <p class="text-brand-100/70 text-sm max-w-md leading-relaxed">از این بخش می‌توانید املاک، کاربران و درخواست‌های مشتریان را مدیریت کنید.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('properties.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-brand-700 hover:bg-brand-50 rounded-xl text-sm font-bold transition-all duration-200 shadow-lg shadow-brand-900/20 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        ملک جدید
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total Properties --}}
            <div class="group bg-white rounded-2xl border border-surface-100 p-5 hover:shadow-lg hover:shadow-surface-200/50 transition-all duration-300 hover:-translate-y-0.5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-brand-50 rounded-xl flex items-center justify-center group-hover:bg-brand-100 transition-colors duration-300">
                        <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-surface-900 mb-0.5">{{ number_format($stats['total']) }}</p>
                <p class="text-xs text-surface-500 font-medium">کل املاک</p>
            </div>

            {{-- Active Properties --}}
            <div class="group bg-white rounded-2xl border border-surface-100 p-5 hover:shadow-lg hover:shadow-surface-200/50 transition-all duration-300 hover:-translate-y-0.5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center group-hover:bg-emerald-100 transition-colors duration-300">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-surface-900 mb-0.5">{{ number_format($stats['active']) }}</p>
                <p class="text-xs text-surface-500 font-medium">املاک فعال</p>
            </div>

            {{-- Sold Properties --}}
            <div class="group bg-white rounded-2xl border border-surface-100 p-5 hover:shadow-lg hover:shadow-surface-200/50 transition-all duration-300 hover:-translate-y-0.5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center group-hover:bg-amber-100 transition-colors duration-300">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-surface-900 mb-0.5">{{ number_format($stats['sold']) }}</p>
                <p class="text-xs text-surface-500 font-medium">فروخته شده</p>
            </div>

            {{-- Pending Inquiries --}}
            <div class="group bg-white rounded-2xl border border-surface-100 p-5 hover:shadow-lg hover:shadow-surface-200/50 transition-all duration-300 hover:-translate-y-0.5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center group-hover:bg-red-100 transition-colors duration-300 relative">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        @if($stats['pending_inquiries'] > 0)
                            <span class="absolute -top-1 -left-1 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center animate-pulse">{{ $stats['pending_inquiries'] > 9 ? '9+' : $stats['pending_inquiries'] }}</span>
                        @endif
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-surface-900 mb-0.5">{{ number_format($stats['pending_inquiries']) }}</p>
                <p class="text-xs text-surface-500 font-medium">درخواست جدید</p>
            </div>
        </div>

        {{-- Secondary Stats --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl border border-surface-100 p-4 flex items-center gap-3 hover:shadow-md transition-shadow duration-300">
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-surface-900 leading-none mb-0.5">{{ number_format($stats['locations']) }}</p>
                    <p class="text-[11px] text-surface-500 font-medium">محله</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-surface-100 p-4 flex items-center gap-3 hover:shadow-md transition-shadow duration-300">
                <div class="w-10 h-10 bg-violet-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-surface-900 leading-none mb-0.5">{{ number_format($stats['types']) }}</p>
                    <p class="text-[11px] text-surface-500 font-medium">نوع ملک</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-surface-100 p-4 flex items-center gap-3 hover:shadow-md transition-shadow duration-300">
                <div class="w-10 h-10 bg-cyan-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-surface-900 leading-none mb-0.5">{{ number_format($stats['users']) }}</p>
                    <p class="text-[11px] text-surface-500 font-medium">کاربر</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-surface-100 p-4 flex items-center gap-3 hover:shadow-md transition-shadow duration-300">
                <div class="w-10 h-10 bg-rose-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-surface-900 leading-none mb-0.5">{{ number_format($stats['inquiries']) }}</p>
                    <p class="text-[11px] text-surface-500 font-medium">کل درخواست‌ها</p>
                </div>
            </div>
        </div>

        {{-- Recent Data --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Recent Properties --}}
            <div class="bg-white rounded-2xl border border-surface-100 overflow-hidden">
                <div class="flex items-center justify-between p-5 pb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 bg-brand-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-surface-800">آخرین املاک</h3>
                    </div>
                    <a href="{{ route('properties.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700 transition-colors flex items-center gap-1">
                        مشاهده همه
                        <svg class="w-3.5 h-3.5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                @if($recentProperties->isEmpty())
                    <div class="p-10 text-center">
                        <div class="w-16 h-16 bg-surface-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-surface-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <p class="text-sm font-semibold text-surface-600 mb-1">هنوز ملکی ثبت نشده</p>
                        <p class="text-xs text-surface-400 mb-4">اولین ملک خود را اضافه کنید</p>
                        <a href="{{ route('properties.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand-50 text-brand-700 rounded-lg text-xs font-semibold hover:bg-brand-100 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            ثبت ملک جدید
                        </a>
                    </div>
                @else
                    <div class="divide-y divide-surface-50">
                        @foreach($recentProperties as $property)
                            <a href="{{ route('properties.show', $property) }}" class="flex items-center gap-3.5 px-5 py-3.5 hover:bg-surface-50/80 transition-all duration-200 group">
                                <div class="w-10 h-10 bg-gradient-to-br from-brand-50 to-brand-100 rounded-xl flex items-center justify-center shrink-0 group-hover:from-brand-100 group-hover:to-brand-200 transition-all duration-300">
                                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-surface-800 truncate group-hover:text-brand-600 transition-colors duration-200">{{ $property->title }}</h4>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <svg class="w-3 h-3 text-surface-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                        <p class="text-xs text-surface-400 truncate">{{ $property->location?->name ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="text-left shrink-0">
                                    <div class="text-sm font-extrabold text-surface-800">{{ number_format($property->price) }}</div>
                                    <div class="text-[10px] text-surface-400 font-medium">تومان</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Recent Inquiries --}}
            <div class="bg-white rounded-2xl border border-surface-100 overflow-hidden">
                <div class="flex items-center justify-between p-5 pb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center relative">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                            @if($stats['pending_inquiries'] > 0)
                                <span class="absolute -top-1 -left-1 w-3.5 h-3.5 bg-red-500 text-white text-[8px] font-bold rounded-full flex items-center justify-center">{{ $stats['pending_inquiries'] > 9 ? '9+' : $stats['pending_inquiries'] }}</span>
                            @endif
                        </div>
                        <h3 class="text-sm font-bold text-surface-800">آخرین درخواست‌ها</h3>
                    </div>
                    <a href="{{ route('admin.inquiries.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700 transition-colors flex items-center gap-1">
                        مشاهده همه
                        <svg class="w-3.5 h-3.5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                @if($recentInquiries->isEmpty())
                    <div class="p-10 text-center">
                        <div class="w-16 h-16 bg-surface-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-surface-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                        <p class="text-sm font-semibold text-surface-600">هنوز درخواستی ثبت نشده</p>
                        <p class="text-xs text-surface-400 mt-1">درخواست‌های مشتریان اینجا نمایش داده می‌شوند</p>
                    </div>
                @else
                    @php
                        $statusLabels = ['pending' => 'در انتظار', 'contacted' => 'تماس گرفته شده', 'closed' => 'بسته شده'];
                        $statusBg = ['pending' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/50', 'contacted' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200/50', 'closed' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/50'];
                        $iconBg = ['pending' => 'bg-amber-50', 'contacted' => 'bg-blue-50', 'closed' => 'bg-emerald-50'];
                        $iconColor = ['pending' => 'text-amber-500', 'contacted' => 'text-blue-500', 'closed' => 'text-emerald-500'];
                    @endphp
                    <div class="divide-y divide-surface-50">
                        @foreach($recentInquiries as $inquiry)
                            <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="flex items-center gap-3.5 px-5 py-3.5 hover:bg-surface-50/80 transition-all duration-200 group">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 {{ $iconBg[$inquiry->status] ?? 'bg-surface-50' }}">
                                    <svg class="w-5 h-5 {{ $iconColor[$inquiry->status] ?? 'text-surface-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-surface-800 truncate group-hover:text-brand-600 transition-colors duration-200">{{ $inquiry->customer_name }}</h4>
                                    <p class="text-xs text-surface-400 truncate mt-0.5">{{ $inquiry->property?->title ?? '-' }}</p>
                                </div>
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold {{ $statusBg[$inquiry->status] ?? 'bg-surface-50 text-surface-600' }}">
                                    {{ $statusLabels[$inquiry->status] ?? $inquiry->status }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <a href="{{ route('properties.create') }}" class="group bg-white rounded-2xl border border-surface-100 p-4 flex flex-col items-center gap-2.5 hover:shadow-lg hover:shadow-brand-100/50 hover:border-brand-200 transition-all duration-300 hover:-translate-y-0.5">
                <div class="w-10 h-10 bg-brand-50 rounded-xl flex items-center justify-center group-hover:bg-brand-100 transition-colors">
                    <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <span class="text-xs font-semibold text-surface-600 group-hover:text-brand-700 transition-colors">ملک جدید</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="group bg-white rounded-2xl border border-surface-100 p-4 flex flex-col items-center gap-2.5 hover:shadow-lg hover:shadow-blue-100/50 hover:border-blue-200 transition-all duration-300 hover:-translate-y-0.5">
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <span class="text-xs font-semibold text-surface-600 group-hover:text-blue-700 transition-colors">کاربر جدید</span>
            </a>
            <a href="{{ route('admin.locations.index') }}" class="group bg-white rounded-2xl border border-surface-100 p-4 flex flex-col items-center gap-2.5 hover:shadow-lg hover:shadow-emerald-100/50 hover:border-emerald-200 transition-all duration-300 hover:-translate-y-0.5">
                <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <span class="text-xs font-semibold text-surface-600 group-hover:text-emerald-700 transition-colors">موقعیت جدید</span>
            </a>
            <a href="{{ route('admin.inquiries.index') }}" class="group bg-white rounded-2xl border border-surface-100 p-4 flex flex-col items-center gap-2.5 hover:shadow-lg hover:shadow-amber-100/50 hover:border-amber-200 transition-all duration-300 hover:-translate-y-0.5">
                <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <span class="text-xs font-semibold text-surface-600 group-hover:text-amber-700 transition-colors">درخواست‌ها</span>
            </a>
        </div>
    </div>
</x-admin-layout>
