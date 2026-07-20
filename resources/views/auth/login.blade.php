<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-surface-900">ورود به حساب کاربری</h2>
        <p class="text-sm text-surface-500 mt-2">خوش آمدید! لطفاً وارد حساب خود شوید.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="'ایمیل'" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="example@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="'رمز عبور'" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="رمز عبور خود را وارد کنید" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                <span class="mr-2 text-sm text-surface-600">مرا به خاطر بسپار</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-brand-600 hover:text-brand-700 underline" href="{{ route('password.request') }}">
                    رمز عبور را فراموش کرده‌اید؟
                </a>
            @endif

            <x-primary-button>
                ورود
            </x-primary-button>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm text-surface-500">
                حساب کاربری ندارید؟
                <a href="{{ route('register') }}" class="text-brand-600 hover:text-brand-700 font-medium">ثبت نام کنید</a>
            </p>
        </div>
    </form>
</x-guest-layout>
