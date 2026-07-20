<x-admin-layout title="جزئیات درخواست">
    <div class="max-w-2xl space-y-6">
        <div class="bg-white rounded-2xl shadow-soft border border-surface-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-surface-800">اطلاعات مشتری</h3>
                @php
                    $statusColors = [
                        'pending' => 'bg-amber-100 text-amber-700',
                        'contacted' => 'bg-blue-100 text-blue-700',
                        'closed' => 'bg-green-100 text-green-700',
                    ];
                    $statusLabels = [
                        'pending' => 'در انتظار',
                        'contacted' => 'تماس گرفته شده',
                        'closed' => 'بسته شده',
                    ];
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$inquiry->status] ?? 'bg-surface-100 text-surface-600' }}">
                    {{ $statusLabels[$inquiry->status] ?? $inquiry->status }}
                </span>
            </div>

            <dl class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-surface-500 mb-0.5">نام</dt>
                    <dd class="font-medium text-surface-800">{{ $inquiry->customer_name ?? $inquiry->customer?->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-surface-500 mb-0.5">تلفن</dt>
                    <dd class="font-medium text-surface-800" dir="ltr">{{ $inquiry->customer_phone ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-surface-500 mb-0.5">ایمیل</dt>
                    <dd class="font-medium text-surface-800" dir="ltr">{{ $inquiry->customer_email ?? $inquiry->customer?->email ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-surface-500 mb-0.5">نوع درخواست</dt>
                    <dd class="font-medium text-surface-800">{{ $inquiry->inquiry_type ?? '-' }}</dd>
                </div>
                @if($inquiry->preferred_date)
                    <div>
                        <dt class="text-surface-500 mb-0.5">تاریخ مورد نظر</dt>
                        <dd class="font-medium text-surface-800">{{ \Carbon\Carbon::parse($inquiry->preferred_date)->format('Y/m/d') }}</dd>
                    </div>
                @endif
                @if($inquiry->preferred_time)
                    <div>
                        <dt class="text-surface-500 mb-0.5">ساعت مورد نظر</dt>
                        <dd class="font-medium text-surface-800">{{ \Carbon\Carbon::parse($inquiry->preferred_time)->format('H:i') }}</dd>
                    </div>
                @endif
                <div class="col-span-2">
                    <dt class="text-surface-500 mb-0.5">تاریخ ثبت</dt>
                    <dd class="font-medium text-surface-800">{{ \Carbon\Carbon::parse($inquiry->created_at)->format('Y/m/d H:i') }}</dd>
                </div>
            </dl>

            @if($inquiry->message)
                <div class="mt-5 p-4 bg-surface-50 rounded-xl">
                    <p class="text-sm text-surface-700 leading-relaxed">{{ $inquiry->message }}</p>
                </div>
            @endif
        </div>

        @if($inquiry->property)
            <div class="bg-white rounded-2xl shadow-soft border border-surface-100 p-6">
                <h3 class="text-lg font-bold text-surface-800 mb-4">ملک مورد نظر</h3>
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 bg-surface-100 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <div class="flex-1">
                        <a href="{{ route('properties.show', $inquiry->property->id) }}" class="font-bold text-surface-800 hover:text-brand-600 transition-colors">{{ $inquiry->property->title }}</a>
                        <p class="text-sm text-surface-500 mt-1">{{ $inquiry->property->location?->name ?? '' }} {{ $inquiry->property->type?->name_fa ? '- ' . $inquiry->property->type->name_fa : '' }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-soft border border-surface-100 p-6">
            <h3 class="text-lg font-bold text-surface-800 mb-4">تغییر وضعیت</h3>
            <form method="POST" action="{{ route('admin.inquiries.update-status', $inquiry->id) }}" class="flex items-center gap-3">
                @csrf
                @method('PATCH')
                <select name="status" class="form-select w-auto">
                    <option value="pending" {{ $inquiry->status === 'pending' ? 'selected' : '' }}>در انتظار</option>
                    <option value="contacted" {{ $inquiry->status === 'contacted' ? 'selected' : '' }}>تماس گرفته شده</option>
                    <option value="closed" {{ $inquiry->status === 'closed' ? 'selected' : '' }}>بسته شده</option>
                </select>
                <button type="submit" class="btn-primary btn-sm">بروزرسانی</button>
            </form>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.inquiries.index') }}" class="btn-ghost">بازگشت به لیست</a>
        </div>
    </div>
</x-admin-layout>
