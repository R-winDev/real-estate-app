<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-surface-900">ثبت نام</h2>
        <p class="text-sm text-surface-500 mt-2">حساب کاربری جدید ایجاد کنید</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="'نام و نام خانوادگی'" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="نام خود را وارد کنید" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="'ایمیل'" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="example@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="'رمز عبور'" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="حداقل ۸ کاراکتر" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="'تکرار رمز عبور'" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="رمز عبور را دوباره وارد کنید" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-brand-600 hover:text-brand-700 underline" href="{{ route('login') }}">
                قبلاً ثبت نام کرده‌اید؟
            </a>

            <x-primary-button>
                ثبت نام
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
