<x-admin-layout title="درخواست‌ها">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-neutral-800">درخواست‌ها</h2>
            <p class="text-sm text-neutral-500 mt-1">{{ $inquiries->total() }} درخواست ثبت شده</p>
        </div>
    </div>

    {{-- Status Filters --}}
    <div class="flex items-center gap-2 mb-6 overflow-x-auto pb-1">
        <a href="{{ route('admin.inquiries.index') }}"
           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200 {{ !request('status') ? 'bg-primary-500 text-white shadow-sm shadow-primary-500/25' : 'bg-white text-neutral-600 border border-neutral-200 hover:border-neutral-300 hover:bg-neutral-50' }}">
            همه
        </a>
        <a href="{{ route('admin.inquiries.index', ['status' => 'pending']) }}"
           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200 {{ request('status') === 'pending' ? 'bg-warning-500 text-white shadow-sm shadow-warning-500/25' : 'bg-white text-neutral-600 border border-neutral-200 hover:border-neutral-300 hover:bg-neutral-50' }}">
            در انتظار
        </a>
        <a href="{{ route('admin.inquiries.index', ['status' => 'contacted']) }}"
           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200 {{ request('status') === 'contacted' ? 'bg-blue-500 text-white shadow-sm shadow-blue-500/25' : 'bg-white text-neutral-600 border border-neutral-200 hover:border-neutral-300 hover:bg-neutral-50' }}">
            تماس گرفته شده
        </a>
        <a href="{{ route('admin.inquiries.index', ['status' => 'closed']) }}"
           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200 {{ request('status') === 'closed' ? 'bg-success-500 text-white shadow-sm shadow-success-500/25' : 'bg-white text-neutral-600 border border-neutral-200 hover:border-neutral-300 hover:bg-neutral-50' }}">
            بسته شده
        </a>
    </div>

    {{-- Table Card --}}
    <div class="rounded-xl border border-neutral-200 bg-white overflow-hidden">
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">ملک</th>
                        <th class="text-center">نام مشتری</th>
                        <th class="text-center">تلفن</th>
                        <th class="text-center">نوع</th>
                        <th class="text-center">تاریخ</th>
                        <th class="text-center">وضعیت</th>
                        <th class="text-center">عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inquiries as $inquiry)
                        <tr class="group">
                            <td class="text-neutral-400 font-mono text-xs">{{ $inquiry->id }}</td>
                            <td>
                                <a href="{{ route('properties.show', $inquiry->property_id) }}" class="inline-flex items-center gap-1.5 text-primary-600 hover:text-primary-700 font-medium transition-colors">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    {{ Str::limit($inquiry->property?->title ?? '-', 25) }}
                                </a>
                            </td>
                            <td>
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 bg-neutral-100 rounded-lg flex items-center justify-center shrink-0">
                                        <span class="text-neutral-500 text-xs font-bold">{{ mb_substr($inquiry->customer_name ?? '?', 0, 1) }}</span>
                                    </div>
                                    <span class="font-medium text-neutral-800">{{ $inquiry->customer_name ?? $inquiry->customer?->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="text-neutral-500 font-mono text-sm" dir="ltr">{{ $inquiry->customer_phone ?? '-' }}</td>
                            <td class="text-neutral-600 text-sm">{{ $inquiry->inquiry_type ?? '-' }}</td>
                            <td class="text-neutral-500 text-sm">{{ \Carbon\Carbon::parse($inquiry->created_at)->format('Y/m/d H:i') }}</td>
                            <td>
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
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold {{ $statusColors[$inquiry->status] ?? 'bg-neutral-100 text-neutral-600' }}">
                                    {{ $statusLabels[$inquiry->status] ?? $inquiry->status }}
                                </span>
                            </td>
                            <td class="text-left">
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('admin.inquiries.show', $inquiry->id) }}"
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-neutral-400 hover:text-primary-600 hover:bg-primary-50 transition-all" title="مشاهده">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" onsubmit="return confirm('آیا از حذف این درخواست اطمینان دارید؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-neutral-400 hover:text-danger hover:bg-danger-50 transition-all" title="حذف">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="flex flex-col items-center justify-center py-16 text-center">
                                    <div class="w-14 h-14 bg-neutral-100 rounded-2xl flex items-center justify-center mb-4">
                                        <svg class="w-7 h-7 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-neutral-600">هنوز درخواستی ثبت نشده است</p>
                                    <p class="text-xs text-neutral-400 mt-1">درخواست‌های مشتریان اینجا نمایش داده می‌شوند</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $inquiries->links() }}
    </div>
</x-admin-layout>
