<x-admin-layout title="جزئیات درخواست">
    <div class="max-w-3xl space-y-6">
        {{-- Page Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.inquiries.index') }}"
               class="w-10 h-10 bg-white rounded-xl border border-neutral-200 flex items-center justify-center hover:bg-neutral-50 hover:border-neutral-300 transition-all duration-200">
                <svg class="w-5 h-5 text-neutral-400 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="text-xl font-bold text-neutral-800">جزئیات درخواست</h2>
                <p class="text-sm text-neutral-500 mt-0.5">مشاهده و مدیریت درخواست مشتری</p>
            </div>
        </div>

        @php
            $statusColors = [
                'pending' => 'bg-warning-50 text-warning-700 ring-1 ring-warning-200/50',
                'contacted' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200/50',
                'closed' => 'bg-success-50 text-success-700 ring-1 ring-success-200/50',
            ];
            $statusLabels = [
                'pending' => 'در انتظار',
                'contacted' => 'تماس گرفته شده',
                'closed' => 'بسته شده',
            ];
        @endphp

        {{-- Customer Info Card --}}
        <div class="rounded-xl border border-neutral-200 bg-white overflow-hidden">
            <div class="px-6 py-4 border-b border-neutral-100 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-neutral-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    اطلاعات مشتری
                </h3>
                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold {{ $statusColors[$inquiry->status] ?? 'bg-neutral-100 text-neutral-600' }}">
                    {{ $statusLabels[$inquiry->status] ?? $inquiry->status }}
                </span>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-neutral-100 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <dt class="text-xs text-neutral-400 mb-1">نام</dt>
                            <dd class="font-semibold text-neutral-800">{{ $inquiry->customer_name ?? $inquiry->customer?->name ?? '-' }}</dd>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-neutral-100 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <dt class="text-xs text-neutral-400 mb-1">تلفن</dt>
                            <dd class="font-semibold text-neutral-800" dir="ltr">{{ $inquiry->customer_phone ?? '-' }}</dd>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-neutral-100 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <dt class="text-xs text-neutral-400 mb-1">ایمیل</dt>
                            <dd class="font-semibold text-neutral-800" dir="ltr">{{ $inquiry->customer_email ?? $inquiry->customer?->email ?? '-' }}</dd>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-neutral-100 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        </div>
                        <div>
                            <dt class="text-xs text-neutral-400 mb-1">نوع درخواست</dt>
                            <dd class="font-semibold text-neutral-800">{{ $inquiry->inquiry_type ?? '-' }}</dd>
                        </div>
                    </div>
                    @if($inquiry->preferred_date)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-neutral-100 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <dt class="text-xs text-neutral-400 mb-1">تاریخ مورد نظر</dt>
                                <dd class="font-semibold text-neutral-800">{{ \Carbon\Carbon::parse($inquiry->preferred_date)->format('Y/m/d') }}</dd>
                            </div>
                        </div>
                    @endif
                    @if($inquiry->preferred_time)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-neutral-100 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <dt class="text-xs text-neutral-400 mb-1">ساعت مورد نظر</dt>
                                <dd class="font-semibold text-neutral-800">{{ \Carbon\Carbon::parse($inquiry->preferred_time)->format('H:i') }}</dd>
                            </div>
                        </div>
                    @endif
                    <div class="sm:col-span-2 flex items-start gap-3">
                        <div class="w-8 h-8 bg-neutral-100 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <dt class="text-xs text-neutral-400 mb-1">تاریخ ثبت</dt>
                            <dd class="font-semibold text-neutral-800">{{ \Carbon\Carbon::parse($inquiry->created_at)->format('Y/m/d H:i') }}</dd>
                        </div>
                    </div>
                </dl>

                @if($inquiry->message)
                    <div class="mt-6 p-4 bg-neutral-50 rounded-xl border border-neutral-100">
                        <p class="text-xs font-semibold text-neutral-400 mb-2">پیام مشتری</p>
                        <p class="text-sm text-neutral-700 leading-relaxed">{{ $inquiry->message }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Property Card --}}
        @if($inquiry->property)
            <div class="rounded-xl border border-neutral-200 bg-white overflow-hidden">
                <div class="px-6 py-4 border-b border-neutral-100">
                    <h3 class="text-sm font-semibold text-neutral-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        ملک مورد نظر
                    </h3>
                </div>
                <div class="p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-primary-50 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-7 h-7 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <div class="flex-1">
                            <a href="{{ route('properties.show', $inquiry->property->id) }}" class="font-bold text-neutral-800 hover:text-primary-600 transition-colors">{{ $inquiry->property->title }}</a>
                            <p class="text-sm text-neutral-500 mt-1">{{ $inquiry->property->location?->name ?? '' }} {{ $inquiry->property->type?->name_fa ? '- ' . $inquiry->property->type->name_fa : '' }}</p>
                            @if($inquiry->property->price)
                                <p class="text-sm font-bold text-primary-600 mt-1.5">{{ number_format($inquiry->property->price) }} تومان</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Status Change Card --}}
        <div class="rounded-xl border border-neutral-200 bg-white overflow-hidden">
            <div class="px-6 py-4 border-b border-neutral-100">
                <h3 class="text-sm font-semibold text-neutral-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    تغییر وضعیت
                </h3>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('admin.inquiries.update-status', $inquiry->id) }}" class="flex items-center gap-3">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="form-select w-full sm:w-auto">
                        <option value="pending" {{ $inquiry->status === 'pending' ? 'selected' : '' }}>در انتظار</option>
                        <option value="contacted" {{ $inquiry->status === 'contacted' ? 'selected' : '' }}>تماس گرفته شده</option>
                        <option value="closed" {{ $inquiry->status === 'closed' ? 'selected' : '' }}>بسته شده</option>
                    </select>
                    <button type="submit" class="btn-primary btn-sm shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        بروزرسانی
                    </button>
                </form>
            </div>
        </div>

        {{-- Back Link --}}
        <div>
            <a href="{{ route('admin.inquiries.index') }}" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-neutral-700 transition-colors">
                <svg class="w-4 h-4 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                بازگشت به لیست
            </a>
        </div>
    </div>
</x-admin-layout>
