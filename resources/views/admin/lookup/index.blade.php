<x-admin-layout :title="$config['label']">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-sm text-surface-500">{{ $items->total() }} مورد</p>
        </div>
        <a href="{{ route('admin.lookup.create', $type) }}" class="btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            افزودن
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-soft border border-surface-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-surface-100 bg-surface-50">
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">#</th>
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">نام انگلیسی</th>
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">نام فارسی</th>
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">پیوند یکتا</th>
                        @if(in_array('category', $config['fields']))
                            <th class="text-right px-5 py-3 font-semibold text-surface-600">دسته‌بندی</th>
                        @endif
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-100">
                    @forelse($items as $item)
                        <tr class="hover:bg-surface-50/50 transition-colors">
                            <td class="px-5 py-3.5 text-surface-400">{{ $item->id }}</td>
                            <td class="px-5 py-3.5 font-medium text-surface-800">{{ $item->name }}</td>
                            <td class="px-5 py-3.5 text-surface-700">{{ $item->name_fa }}</td>
                            <td class="px-5 py-3.5"><code class="text-xs bg-surface-100 px-2 py-0.5 rounded">{{ $item->slug }}</code></td>
                            @if(in_array('category', $config['fields']))
                                <td class="px-5 py-3.5 text-surface-600">{{ $item->category ?? '-' }}</td>
                            @endif
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.lookup.edit', [$type, $item->id]) }}" class="text-brand-600 hover:text-brand-700 text-xs font-medium">ویرایش</a>
                                    <form method="POST" action="{{ route('admin.lookup.destroy', [$type, $item->id]) }}" onsubmit="return confirm('آیا از حذف این مورد اطمینان دارید؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600 text-xs font-medium">حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-surface-400">
                                هنوز موردی ثبت نشده است
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $items->links() }}
    </div>
</x-admin-layout>
