<x-admin-layout title="درخواست‌ها">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-sm text-surface-500">{{ $inquiries->total() }} درخواست</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.inquiries.index') }}" class="text-sm px-3 py-1.5 rounded-lg {{ !request('status') ? 'bg-brand-100 text-brand-700' : 'text-surface-500 hover:bg-surface-100' }}">همه</a>
            <a href="{{ route('admin.inquiries.index', ['status' => 'pending']) }}" class="text-sm px-3 py-1.5 rounded-lg {{ request('status') === 'pending' ? 'bg-amber-100 text-amber-700' : 'text-surface-500 hover:bg-surface-100' }}>در انتظار</a>
            <a href="{{ route('admin.inquiries.index', ['status' => 'contacted']) }}" class="text-sm px-3 py-1.5 rounded-lg {{ request('status') === 'contacted' ? 'bg-blue-100 text-blue-700' : 'text-surface-500 hover:bg-surface-100' }}>تماس گرفته شده</a>
            <a href="{{ route('admin.inquiries.index', ['status' => 'closed']) }}" class="text-sm px-3 py-1.5 rounded-lg {{ request('status') === 'closed' ? 'bg-green-100 text-green-700' : 'text-surface-500 hover:bg-surface-100' }}>بسته شده</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-soft border border-surface-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-surface-100 bg-surface-50">
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">#</th>
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">ملک</th>
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">نام مشتری</th>
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">تلفن</th>
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">نوع</th>
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">تاریخ</th>
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">وضعیت</th>
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-100">
                    @forelse($inquiries as $inquiry)
                        <tr class="hover:bg-surface-50/50 transition-colors">
                            <td class="px-5 py-3.5 text-surface-400">{{ $inquiry->id }}</td>
                            <td class="px-5 py-3.5">
                                <a href="{{ route('properties.show', $inquiry->property_id) }}" class="text-brand-600 hover:text-brand-700 font-medium text-xs">
                                    {{ Str::limit($inquiry->property?->title ?? '-', 30) }}
                                </a>
                            </td>
                            <td class="px-5 py-3.5 font-medium text-surface-800">{{ $inquiry->customer_name ?? $inquiry->customer?->name ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-surface-500" dir="ltr">{{ $inquiry->customer_phone ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-surface-600">{{ $inquiry->inquiry_type ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-surface-500 text-xs">{{ \Carbon\Carbon::parse($inquiry->created_at)->format('Y/m/d H:i') }}</td>
                            <td class="px-5 py-3.5">
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
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$inquiry->status] ?? 'bg-surface-100 text-surface-600' }}">
                                    {{ $statusLabels[$inquiry->status] ?? $inquiry->status }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.inquiries.show', $inquiry->id) }}" class="text-brand-600 hover:text-brand-700 text-xs font-medium">مشاهده</a>
                                    <form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" onsubmit="return confirm('آیا از حذف این درخواست اطمینان دارید؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600 text-xs font-medium">حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-surface-400">
                                هنوز درخواستی ثبت نشده است
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $inquiries->links() }}
    </div>
</x-admin-layout>
