<x-admin-layout title="ویرایش کاربر">
    <div class="max-w-xl">
        <div class="bg-white rounded-2xl shadow-soft border border-surface-100 p-6">
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-surface-700 mb-1">نام</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-input" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-surface-700 mb-1">ایمیل</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-input" dir="ltr" required>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-surface-700 mb-1">تلفن</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="form-input" dir="ltr">
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-surface-700 mb-1">رمز عبور <span class="text-surface-400">(خالی بگذارید بدون تغییر)</span></label>
                    <input type="password" name="password" id="password" class="form-input" dir="ltr">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-surface-700 mb-1">تکرار رمز عبور</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" dir="ltr">
                </div>

                <div class="flex items-center gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="is_admin" value="0">
                        <input type="checkbox" name="is_admin" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }} class="form-checkbox rounded border-surface-300 text-brand-600 focus:ring-brand-500">
                        <span class="text-sm text-surface-700">مدیر</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="must_change_password" value="0">
                        <input type="checkbox" name="must_change_password" value="1" {{ old('must_change_password', $user->must_change_password) ? 'checked' : '' }} class="form-checkbox rounded border-surface-300 text-brand-600 focus:ring-brand-500">
                        <span class="text-sm text-surface-700">تغییر اجباری رمز</span>
                    </label>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="btn-primary">بروزرسانی</button>
                    <a href="{{ route('admin.users.index') }}" class="btn-ghost">انصراف</a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
