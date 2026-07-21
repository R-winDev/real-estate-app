<x-admin-layout title="کاربران">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-neutral-800">کاربران</h2>
            <p class="text-sm text-neutral-500 mt-1">{{ $users->total() }} کاربر ثبت شده</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            افزودن کاربر
        </a>
    </div>

    {{-- Table Card --}}
    <div class="rounded-xl border border-neutral-200 bg-white overflow-hidden">
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">کاربر</th>
                        <th class="text-center">ایمیل</th>
                        <th class="text-center">تلفن</th>
                        <th class="text-center">نقش</th>
                        <th class="text-center">عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="group">
                            <td class="text-neutral-400 font-mono text-xs">{{ $user->id }}</td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 {{ $user->is_admin ? 'bg-gradient-to-br from-primary-500 to-primary-600' : 'bg-gradient-to-br from-neutral-400 to-neutral-500' }} rounded-xl flex items-center justify-center shrink-0 shadow-sm">
                                        <span class="text-white text-xs font-bold">{{ mb_substr($user->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-neutral-800 block">{{ $user->name }}</span>
                                        <span class="text-xs text-neutral-400">عضو از {{ \Carbon\Carbon::parse($user->created_at)->format('Y/m/d') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-neutral-600 text-sm" dir="ltr">{{ $user->email }}</td>
                            <td class="text-neutral-500 text-sm" dir="ltr">{{ $user->phone ?? '-' }}</td>
                            <td>
                                @if($user->is_admin)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-primary-50 text-primary-700 ring-1 ring-primary-200/50">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                        مدیر
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-neutral-100 text-neutral-600">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        کاربر
                                    </span>
                                @endif
                            </td>
                            <td class="text-left">
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-neutral-400 hover:text-primary-600 hover:bg-primary-50 transition-all" title="ویرایش">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onsubmit="return confirm('آیا از حذف این کاربر اطمینان دارید؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-neutral-400 hover:text-danger hover:bg-danger-50 transition-all" title="حذف">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="flex flex-col items-center justify-center py-16 text-center">
                                    <div class="w-14 h-14 bg-neutral-100 rounded-2xl flex items-center justify-center mb-4">
                                        <svg class="w-7 h-7 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-neutral-600">هنوز کاربری ثبت نشده است</p>
                                    <a href="{{ route('admin.users.create') }}" class="text-xs text-primary-600 hover:text-primary-700 font-medium mt-2 transition-colors">+ افزودن اولین کاربر</a>
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
        {{ $users->links() }}
    </div>
</x-admin-layout>
