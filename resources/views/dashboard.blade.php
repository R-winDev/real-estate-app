<x-admin-layout title="داشبورد">
    <div class="space-y-6">

        {{-- Welcome Banner --}}
        <div class="relative overflow-hidden rounded-xl bg-gradient-to-l from-primary-100 to-primary-50 border border-primary-200 p-6 sm:p-8">
            <div class="absolute -top-16 -right-16 w-48 h-48 bg-primary-200/40 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-16 -left-16 w-40 h-40 bg-primary-200/40 rounded-full blur-2xl"></div>
            <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
                <div>
                    <h3 class="text-xl sm:text-2xl font-bold text-neutral-950">خوش آمدید، {{ Auth::user()->name }}!</h3>
                    <p class="text-neutral-500 text-sm mt-1">از این بخش می‌توانید املاک، کاربران و درخواست‌های مشتریان را مدیریت کنید.</p>
                </div>
                <a href="{{ route('properties.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-500 text-white hover:bg-primary-600 rounded-lg text-sm font-bold transition-all duration-200 shadow-sm shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    ملک جدید
                </a>
            </div>
        </div>

        {{-- Primary Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total Properties --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-11 h-11 rounded-xl bg-primary-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-neutral-950 mb-0.5">{{ number_format($stats['total']) }}</p>
                <p class="text-xs text-neutral-500 font-medium">کل املاک</p>
            </div>

            {{-- For Sale --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-11 h-11 rounded-xl bg-success-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-success-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-neutral-950 mb-0.5">{{ number_format($stats['for_sale']) }}</p>
                <p class="text-xs text-neutral-500 font-medium">املاک فروشی</p>
            </div>

            {{-- For Rent --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-11 h-11 rounded-xl bg-accent-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-neutral-950 mb-0.5">{{ number_format($stats['for_rent']) }}</p>
                <p class="text-xs text-neutral-500 font-medium">املاک اجاره‌ای</p>
            </div>

            {{-- Pending Inquiries --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-5">
                <div class="flex items-center justify-between mb-4 relative">
                    <div class="w-11 h-11 rounded-xl bg-danger-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-danger-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        @if($stats['pending_inquiries'] > 0)
                            <span class="absolute -top-1.5 -right-1.5 w-4 h-4 bg-danger-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center">{{ $stats['pending_inquiries'] > 9 ? '9+' : $stats['pending_inquiries'] }}</span>
                        @endif
                    </div>
                </div>
                <p class="text-2xl font-bold text-neutral-950 mb-0.5">{{ number_format($stats['pending_inquiries']) }}</p>
                <p class="text-xs text-neutral-500 font-medium">درخواست جدید</p>
            </div>
        </div>

        {{-- Secondary Stats --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="rounded-xl border border-neutral-200 bg-white p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-success-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-success-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-lg font-bold text-neutral-950 leading-none mb-0.5">{{ number_format($stats['sale_active']) }}</p>
                    <p class="text-xs text-neutral-500 font-medium">فروش فعال</p>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-accent-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-lg font-bold text-neutral-950 leading-none mb-0.5">{{ number_format($stats['rental_active']) }}</p>
                    <p class="text-xs text-neutral-500 font-medium">اجاره فعال</p>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-warning-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-warning-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-lg font-bold text-neutral-950 leading-none mb-0.5">{{ number_format($stats['sold']) }}</p>
                    <p class="text-xs text-neutral-500 font-medium">فروخته شده</p>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-primary-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <p class="text-lg font-bold text-neutral-950 leading-none mb-0.5">{{ number_format($stats['locations']) }}</p>
                    <p class="text-xs text-neutral-500 font-medium">محله‌ها</p>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-danger-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-danger-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <p class="text-lg font-bold text-neutral-950 leading-none mb-0.5">{{ number_format($stats['inquiries']) }}</p>
                    <p class="text-xs text-neutral-500 font-medium">کل درخواست‌ها</p>
                </div>
            </div>
        </div>

        {{-- Recent Data --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Recent Properties --}}
            <div class="rounded-xl border border-neutral-200 bg-white overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-neutral-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-primary-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-neutral-950">آخرین املاک</h3>
                    </div>
                    <a href="{{ route('properties.index') }}" class="text-xs font-semibold text-primary-600 hover:text-primary-700 transition-colors flex items-center gap-1">
                        مشاهده همه
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                @if($recentProperties->isEmpty())
                    <div class="p-10 text-center">
                        <div class="w-14 h-14 rounded-xl bg-neutral-50 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <p class="text-sm font-semibold text-neutral-600 mb-1">هنوز ملکی ثبت نشده</p>
                        <p class="text-xs text-neutral-400 mb-4">اولین ملک خود را اضافه کنید</p>
                        <a href="{{ route('properties.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary-50 text-primary-700 rounded-lg text-xs font-semibold hover:bg-primary-100 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            ثبت ملک جدید
                        </a>
                    </div>
                @else
                    <div class="divide-y divide-neutral-100">
                        @foreach($recentProperties as $property)
                            <a href="{{ route('properties.show', $property) }}" class="flex items-center gap-3.5 px-5 py-3.5 hover:bg-neutral-50 transition-all duration-200 group">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-neutral-950 truncate group-hover:text-primary-600 transition-colors">{{ $property->title }}</h4>
                                    <p class="text-xs text-neutral-500 truncate mt-0.5">
                                        {{ $property->location?->name ?? '-' }}
                                        @if($property->listing_type === 'rental')
                                            <span class="inline-flex items-center px-1.5 py-0.5 bg-accent-50 text-accent-600 rounded text-[9px] font-bold mr-1">اجاره‌ای</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="text-left shrink-0">
                                    @if($property->listing_type === 'rental')
                                        <div class="text-xs font-bold text-accent-600">رهن: {{ number_format($property->deposit_amount ?? 0) }}</div>
                                        <div class="text-[10px] text-primary-600 font-medium">اجاره: {{ number_format($property->rent_amount ?? 0) }}</div>
                                    @else
                                        <div class="text-sm font-bold text-neutral-950">{{ number_format($property->price) }}</div>
                                        <div class="text-[10px] text-neutral-400 font-medium">تومان</div>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Recent Inquiries --}}
            <div class="rounded-xl border border-neutral-200 bg-white overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-neutral-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-warning-50 flex items-center justify-center relative">
                            <svg class="w-4 h-4 text-warning-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                            @if($stats['pending_inquiries'] > 0)
                                <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-danger-500 text-white text-[8px] font-bold rounded-full flex items-center justify-center">{{ $stats['pending_inquiries'] > 9 ? '9+' : $stats['pending_inquiries'] }}</span>
                            @endif
                        </div>
                        <h3 class="text-sm font-bold text-neutral-950">آخرین درخواست‌ها</h3>
                    </div>
                    <a href="{{ route('admin.inquiries.index') }}" class="text-xs font-semibold text-primary-600 hover:text-primary-700 transition-colors flex items-center gap-1">
                        مشاهده همه
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                @if($recentInquiries->isEmpty())
                    <div class="p-10 text-center">
                        <div class="w-14 h-14 rounded-xl bg-neutral-50 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                        <p class="text-sm font-semibold text-neutral-600">هنوز درخواستی ثبت نشده</p>
                        <p class="text-xs text-neutral-400 mt-1">درخواست‌های مشتریان اینجا نمایش داده می‌شوند</p>
                    </div>
                @else
                    @php
                        $statusLabels = ['pending' => 'در انتظار', 'contacted' => 'تماس گرفته شده', 'closed' => 'بسته شده'];
                        $statusClass = ['pending' => 'bg-warning-50 text-warning-700', 'contacted' => 'bg-primary-50 text-primary-700', 'closed' => 'bg-success-50 text-success-700'];
                    @endphp
                    <div class="divide-y divide-neutral-100">
                        @foreach($recentInquiries as $inquiry)
                            <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="flex items-center gap-3.5 px-5 py-3.5 hover:bg-neutral-50 transition-all duration-200 group">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-neutral-950 truncate group-hover:text-primary-600 transition-colors">{{ $inquiry->customer_name }}</h4>
                                    <p class="text-xs text-neutral-500 truncate mt-0.5">{{ $inquiry->property?->title ?? '-' }}</p>
                                </div>
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold {{ $statusClass[$inquiry->status] ?? 'bg-neutral-50 text-neutral-600' }}">
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
            <a href="{{ route('properties.create') }}" class="rounded-xl border border-neutral-200 bg-white p-4 flex flex-col items-center gap-2.5 hover:border-primary-500 hover:shadow-sm transition-all duration-200">
                <div class="w-10 h-10 rounded-lg bg-primary-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <span class="text-xs font-semibold text-neutral-600">ملک جدید</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="rounded-xl border border-neutral-200 bg-white p-4 flex flex-col items-center gap-2.5 hover:border-primary-500 hover:shadow-sm transition-all duration-200">
                <div class="w-10 h-10 rounded-lg bg-success-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-success-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <span class="text-xs font-semibold text-neutral-600">کاربر جدید</span>
            </a>
            <a href="{{ route('admin.locations.index') }}" class="rounded-xl border border-neutral-200 bg-white p-4 flex flex-col items-center gap-2.5 hover:border-primary-500 hover:shadow-sm transition-all duration-200">
                <div class="w-10 h-10 rounded-lg bg-warning-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-warning-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <span class="text-xs font-semibold text-neutral-600">موقعیت جدید</span>
            </a>
            <a href="{{ route('admin.inquiries.index') }}" class="rounded-xl border border-neutral-200 bg-white p-4 flex flex-col items-center gap-2.5 hover:border-primary-500 hover:shadow-sm transition-all duration-200">
                <div class="w-10 h-10 rounded-lg bg-danger-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-danger-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <span class="text-xs font-semibold text-neutral-600">درخواست‌ها</span>
            </a>
        </div>
    </div>
</x-admin-layout>
