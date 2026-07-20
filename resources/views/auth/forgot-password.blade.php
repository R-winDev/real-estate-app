<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-neutral-900">بازیابی رمز عبور</h2>
        <p class="text-sm text-neutral-500 mt-2">رمز عبور خود را بازیابی کنید</p>
    </div>

    <div class="mb-4 text-sm text-neutral-600 leading-relaxed">
        رمز عبور خود را فراموش کرده‌اید؟ نگران نباشید. ایمیل خود را وارد کنید تا لینک بازیابی رمز عبور برایتان ارسال شود.
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="'ایمیل'" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="example@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <a class="text-sm text-primary-600 hover:text-primary-700 font-medium" href="{{ route('login') }}">
                بازگشت به ورود
            </a>
            <button type="submit" class="btn-primary">
                ارسال لینک بازیابی
            </button>
        </div>
    </form>
</x-guest-layout>
