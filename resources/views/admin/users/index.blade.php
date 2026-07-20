<x-admin-layout title="کاربران">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-sm text-surface-500">{{ $users->total() }} کاربر</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            افزودن کاربر
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-soft border border-surface-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-surface-100 bg-surface-50">
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">#</th>
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">نام</th>
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">ایمیل</th>
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">تلفن</th>
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">نقش</th>
                        <th class="text-right px-5 py-3 font-semibold text-surface-600">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-surface-50/50 transition-colors">
                            <td class="px-5 py-3.5 text-surface-400">{{ $user->id }}</td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 bg-brand-500 rounded-lg flex items-center justify-center shrink-0">
                                        <span class="text-white text-xs font-bold">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                    <span class="font-medium text-surface-800">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-surface-600" dir="ltr">{{ $user->email }}</td>
                            <td class="px-5 py-3.5 text-surface-500" dir="ltr">{{ $user->phone ?? '-' }}</td>
                            <td class="px-5 py-3.5">
                                @if($user->is_admin)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-100 text-brand-700">مدیر</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-surface-100 text-surface-600">کاربر</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-brand-600 hover:text-brand-700 text-xs font-medium">ویرایش</a>
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onsubmit="return confirm('آیا از حذف این کاربر اطمینان دارید؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-600 text-xs font-medium">حذف</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-surface-400">
                                هنوز کاربری ثبت نشده است
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</x-admin-layout>
