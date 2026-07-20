<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 text-white mb-4 shadow-lg">
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-surface-900">تغییر اجباری رمز عبور</h2>
        <p class="mt-2 text-sm text-surface-500">برای ادامه، لطفاً رمز عبور خود را تغییر دهید</p>
    </div>

    <x-alert type="warning" class="mb-6">برای امنیت حساب کاربری، باید رمز عبور پیش‌فرض را تغییر دهید.</x-alert>

    <form method="POST" action="{{ route('password.force.update') }}" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="password" :value="'رمز عبور جدید'" />
            <x-text-input id="password" class="block mt-1.5 w-full" type="password" name="password" required autocomplete="new-password" placeholder="رمز عبور جدید را وارد کنید" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="'تکرار رمز عبور جدید'" />
            <x-text-input id="password_confirmation" class="block mt-1.5 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="رمز عبور جدید را دوباره وارد کنید" />
        </div>

        <button type="submit" class="btn-primary w-full">
            تغییر رمز عبور
        </button>
    </form>
</x-guest-layout>
