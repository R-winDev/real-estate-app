<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-surface-900">بازیابی رمز عبور</h2>
        <p class="text-sm text-surface-500 mt-1">رمز عبور خود را بازیابی کنید</p>
    </div>

    <div class="mb-4 text-sm text-surface-600 leading-relaxed">
        رمز عبور خود را فراموش کرده‌اید؟ نگران نباشید. ایمیل خود را وارد کنید تا لینک بازیابی رمز عبور برایتان ارسال شود.
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="'ایمیل'" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="example@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-brand-600 hover:text-brand-700 underline" href="{{ route('login') }}">
                بازگشت به ورود
            </a>
            <x-primary-button>
                ارسال لینک بازیابی
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
