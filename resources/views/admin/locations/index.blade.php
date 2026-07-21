<x-admin-layout title="موقعیت‌ها">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-neutral-800">موقعیت‌ها</h2>
            <p class="text-sm text-neutral-500 mt-1">{{ $locations->total() }} موقعیت ثبت شده</p>
        </div>
        <a href="{{ route('admin.locations.create') }}" class="btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            افزودن موقعیت
        </a>
    </div>

    {{-- Table Card --}}
    <div class="rounded-xl border border-neutral-200 bg-white overflow-hidden">
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">نام</th>
                        <th class="text-center">پیوند یکتا</th>
                        <th class="text-center">والد</th>
                        <th class="text-center">طول جغرافیایی</th>
                        <th class="text-center">عرض جغرافیایی</th>
                        <th class="text-center">عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($locations as $location)
                        <tr class="group">
                            <td class="text-neutral-400 font-mono text-xs">{{ $location->id }}</td>
                            <td>
                                <div class="flex items-center gap-2.5">
                                    <span class="w-2 h-2 rounded-full bg-success-400 shrink-0 ring-2 ring-success-100"></span>
                                    <span class="font-medium text-neutral-800">{{ $location->name }}</span>
                                </div>
                            </td>
                            <td><code class="text-xs bg-neutral-100 text-neutral-600 px-2 py-0.5 rounded-md font-mono">{{ $location->slug }}</code></td>
                            <td>
                                @if($location->parent)
                                    <span class="flex items-center gap-1.5 text-neutral-600 text-sm">
                                        <svg class="w-3.5 h-3.5 text-neutral-400 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        {{ $location->parent->name }}
                                    </span>
                                @else
                                    <span class="text-neutral-300">-</span>
                                @endif
                            </td>
                            <td class="text-neutral-500 font-mono text-sm" dir="ltr">{{ $location->longitude ?? '-' }}</td>
                            <td class="text-neutral-500 font-mono text-sm" dir="ltr">{{ $location->latitude ?? '-' }}</td>
                            <td class="text-left">
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('admin.locations.edit', $location->id) }}"
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-neutral-400 hover:text-primary-600 hover:bg-primary-50 transition-all" title="ویرایش">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.locations.destroy', $location->id) }}" onsubmit="return confirm('آیا از حذف این موقعیت اطمینان دارید؟')">
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
                            <td colspan="7">
                                <div class="flex flex-col items-center justify-center py-16 text-center">
                                    <div class="w-14 h-14 bg-neutral-100 rounded-2xl flex items-center justify-center mb-4">
                                        <svg class="w-7 h-7 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-neutral-600">هنوز موقعیتی ثبت نشده است</p>
                                    <a href="{{ route('admin.locations.create') }}" class="text-xs text-primary-600 hover:text-primary-700 font-medium mt-2 transition-colors">+ افزودن اولین موقعیت</a>
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
        {{ $locations->links() }}
    </div>
</x-admin-layout>
