<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-surface-900 leading-tight">
            داشبورد
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Welcome Card -->
            <div class="card p-6 mb-6 bg-gradient-to-l from-brand-600 via-brand-700 to-brand-800 text-white relative overflow-hidden">
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
                <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 24px 24px;"></div>
                <div class="relative">
                    <h3 class="text-xl font-bold mb-2">خوش آمدید، {{ Auth::user()->name }}!</h3>
                    <p class="text-brand-100/80">از این بخش می‌توانید املاک خود را مدیریت کنید.</p>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="card p-5 group hover:shadow-glow transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-surface-900">{{ $stats['total'] }}</div>
                            <div class="text-sm text-surface-500">کل املاک</div>
                        </div>
                    </div>
                </div>

                <div class="card p-5 group hover:shadow-glow transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-surface-900">{{ $stats['active'] }}</div>
                            <div class="text-sm text-surface-500">فعال</div>
                        </div>
                    </div>
                </div>

                <div class="card p-5 group hover:shadow-glow transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-surface-900">{{ $stats['sold'] }}</div>
                            <div class="text-sm text-surface-500">فروخته شده</div>
                        </div>
                    </div>
                </div>

                <div class="card p-5 group hover:shadow-glow transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-surface-900">{{ $stats['inactive'] }}</div>
                            <div class="text-sm text-surface-500">غیرفعال</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Properties -->
            <div class="card">
                <div class="flex justify-between items-center p-6 border-b border-surface-100">
                    <h3 class="text-lg font-bold text-surface-900">آخرین املاک ثبت شده</h3>
                    <a href="{{ route('properties.create') }}" class="btn-primary btn-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        ملک جدید
                    </a>
                </div>

                @if($recentProperties->isEmpty())
                    <div class="p-12 text-center text-surface-500">
                        <div class="w-20 h-20 bg-surface-100 rounded-3xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-surface-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <p class="text-lg font-medium mb-1">هنوز ملکی ثبت نشده</p>
                        <p class="text-sm mb-4">اولین ملک خود را ثبت کنید</p>
                        <a href="{{ route('properties.create') }}" class="btn-primary">ثبت ملک جدید</a>
                    </div>
                @else
                    <div class="divide-y divide-surface-100">
                        @foreach($recentProperties as $property)
                            <a href="{{ route('properties.show', $property) }}" class="flex items-center gap-4 p-4 hover:bg-surface-50/80 transition-all duration-200 group">
                                <div class="w-14 h-14 bg-gradient-to-br from-brand-100 to-brand-50 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform duration-200">
                                    <svg class="w-6 h-6 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-surface-900 truncate group-hover:text-brand-600 transition-colors duration-200">{{ $property->title }}</h4>
                                    <p class="text-sm text-surface-500 truncate">{{ $property->location?->name ?? '-' }}</p>
                                </div>
                                <div class="text-left shrink-0">
                                    <div class="font-bold text-brand-600">{{ number_format($property->price) }}</div>
                                    <div class="text-xs text-surface-400">تومان</div>
                                </div>
                                @if($property->status)
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium
                                        {{ $property->status->slug === 'active' ? 'badge-success' : ($property->status->slug === 'sold' ? 'badge-warning' : 'badge-neutral') }}">
                                        {{ $property->status->name_fa }}
                                    </span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
