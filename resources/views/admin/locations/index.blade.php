<x-admin-layout title="موقعیت‌ها">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-sm text-surface-500">{{ $locations->total() }} مورد</p>
        </div>
        <a href="{{ route('admin.locations.create') }}" class="btn-primary btn-sm">
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
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">نام</th>
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">پیوند یکتا</th>
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">والد</th>
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">طول جغرافیایی</th>
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">عرض جغرافیایی</th>
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-100">
                    @forelse($locations as $location)
                        <tr class="hover:bg-surface-50/50 transition-colors">
                            <td class="px-5 py-3.5 text-surface-400">{{ $location->id }}</td>
                            <td class="px-5 py-3.5 font-medium text-surface-800">{{ $location->name }}</td>
                            <td class="px-5 py-3.5"><code class="text-xs bg-surface-100 px-2 py-0.5 rounded">{{ $location->slug }}</code></td>
                            <td class="px-5 py-3.5 text-surface-600">{{ $location->parent?->name ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-surface-500" dir="ltr">{{ $location->longitude ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-surface-500" dir="ltr">{{ $location->latitude ?? '-' }}</td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.locations.edit', $location->id) }}" class="text-brand-600 hover:text-brand-700 text-xs font-medium">ویرایش</a>
                                    <form method="POST" action="{{ route('admin.locations.destroy', $location->id) }}" onsubmit="return confirm('آیا از حذف این موقعیت اطمینان دارید؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600 text-xs font-medium">حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-surface-400">
                                هنوز موقعیتی ثبت نشده است
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $locations->links() }}
    </div>
</x-admin-layout>
