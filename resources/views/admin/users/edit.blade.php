<x-admin-layout title="ویرایش کاربر">
    <div class="max-w-xl">
        {{-- Page Header --}}
        <div class="mb-6">
            <h2 class="text-xl font-bold text-neutral-800">ویرایش کاربر</h2>
            <p class="text-sm text-neutral-500 mt-1">{{ $user->name }}</p>
        </div>

        {{-- Form Card --}}
        <div class="rounded-xl border border-neutral-200 bg-white overflow-hidden">
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                @method('PUT')

                {{-- Section: Personal Info --}}
                <div class="px-6 py-4 border-b border-neutral-100">
                    <h3 class="text-sm font-semibold text-neutral-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        اطلاعات شخصی
                    </h3>
                </div>
                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-2 gap-4">
                        <x-form-input name="name" :value="old('name', $user->name)" label="نام" required />
                        <x-form-input name="email" :value="old('email', $user->email)" label="ایمیل" type="email" dir="ltr" required />
                    </div>
                    <x-form-input name="phone" :value="old('phone', $user->phone)" label="تلفن" dir="ltr" />
                </div>

                {{-- Section: Security --}}
                <div class="px-6 py-4 border-t border-neutral-100 border-b border-neutral-100">
                    <h3 class="text-sm font-semibold text-neutral-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        امنیت حساب
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <x-form-input name="password" label="رمز عبور" type="password" dir="ltr" :optional="true" />
                        <x-form-input name="password_confirmation" label="تکرار رمز عبور" type="password" dir="ltr" />
                    </div>
                </div>

                {{-- Section: Role --}}
                <div class="px-6 py-4 border-t border-neutral-100 border-b border-neutral-100">
                    <h3 class="text-sm font-semibold text-neutral-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        تنظیمات نقش
                    </h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2.5 cursor-pointer group">
                            <input type="hidden" name="is_admin" value="0">
                            <input type="checkbox" name="is_admin" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }} class="w-4 h-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500 transition-all">
                            <span class="text-sm text-neutral-700 group-hover:text-neutral-900 transition-colors">مدیر سیستم</span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer group">
                            <input type="hidden" name="must_change_password" value="0">
                            <input type="checkbox" name="must_change_password" value="1" {{ old('must_change_password', $user->must_change_password) ? 'checked' : '' }} class="w-4 h-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500 transition-all">
                            <span class="text-sm text-neutral-700 group-hover:text-neutral-900 transition-colors">تغییر اجباری رمز</span>
                        </label>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="px-6 py-4 border-t border-neutral-100 bg-neutral-50/50 flex items-center gap-3">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        بروزرسانی
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn-secondary">انصراف</a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
