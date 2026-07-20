<x-admin-layout :title="$config['label']">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-neutral-800">{{ $config['label'] }}</h2>
            <p class="text-sm text-neutral-500 mt-1">{{ $items->total() }} مورد ثبت شده</p>
        </div>
        <a href="{{ route('admin.lookup.create', $type) }}" class="btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            افزودن {{ $config['label'] }}
        </a>
    </div>

    {{-- Search Bar --}}
    <form method="GET" action="{{ route('admin.lookup.index', $type) }}" class="mb-6">
        <div class="relative">
            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="جستجو..."
                   class="form-input pr-11 pl-10" />
            @if(request('search'))
                <a href="{{ route('admin.lookup.index', $type) }}" class="absolute inset-y-0 left-0 pl-4 flex items-center text-neutral-400 hover:text-neutral-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
            @endif
        </div>
    </form>

    {{-- Table Card --}}
    <div class="rounded-xl border border-neutral-200 bg-white overflow-hidden">
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>نام انگلیسی</th>
                        <th>نام فارسی</th>
                        <th>پیوند یکتا</th>
                        @if(in_array('category', $config['fields']))
                            <th>دسته‌بندی</th>
                        @endif
                        <th class="text-left">عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr class="group">
                            <td class="text-neutral-400 font-mono text-xs">{{ $item->id }}</td>
                            <td class="text-neutral-700">{{ $item->name }}</td>
                            <td class="font-medium text-neutral-800">{{ $item->name_fa }}</td>
                            <td>
                                <code class="text-xs bg-neutral-100 text-neutral-600 px-2 py-0.5 rounded-md font-mono">{{ $item->slug }}</code>
                            </td>
                            @if(in_array('category', $config['fields']))
                                <td>
                                    @if($item->category)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-neutral-100 text-neutral-600">{{ $item->category }}</span>
                                    @else
                                        <span class="text-neutral-300">—</span>
                                    @endif
                                </td>
                            @endif
                            <td class="text-left">
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('admin.lookup.edit', [$type, $item->id]) }}"
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-neutral-400 hover:text-primary-600 hover:bg-primary-50 transition-all" title="ویرایش">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.lookup.destroy', [$type, $item->id]) }}" onsubmit="return confirm('آیا از حذف این مورد اطمینان دارید؟')">
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
                            <td colspan="{{ count($config['fields']) + 3 }}">
                                <div class="flex flex-col items-center justify-center py-16 text-center">
                                    <div class="w-14 h-14 bg-neutral-100 rounded-2xl flex items-center justify-center mb-4">
                                        @if(request('search'))
                                            <svg class="w-7 h-7 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                        @else
                                            <svg class="w-7 h-7 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        @endif
                                    </div>
                                    @if(request('search'))
                                        <p class="text-sm font-semibold text-neutral-600">هیچ نتیجه‌ای برای «{{ request('search') }}» یافت نشد</p>
                                        <a href="{{ route('admin.lookup.index', $type) }}" class="text-xs text-primary-600 hover:text-primary-700 font-medium mt-2 transition-colors">پاک کردن جستجو</a>
                                    @else
                                        <p class="text-sm font-semibold text-neutral-600">هنوز موردی ثبت نشده است</p>
                                        <a href="{{ route('admin.lookup.create', $type) }}" class="text-xs text-primary-600 hover:text-primary-700 font-medium mt-2 transition-colors">+ افزودن اولین مورد</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($items->hasPages())
        <div class="mt-6">
            {{ $items->links() }}
        </div>
    @endif
</x-admin-layout>
