<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-surface-900">تایید هویت</h2>
        <p class="text-sm text-surface-500 mt-2">لطفاً برای ادامه، رمز عبور خود را تایید کنید.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="password" :value="'رمز عبور'" />
            <x-text-input id="password" class="block mt-1.5 w-full" type="password" name="password" required autocomplete="current-password" placeholder="رمز عبور خود را وارد کنید" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <button type="submit" class="btn-primary w-full">
            تایید
        </button>
    </form>
</x-guest-layout>
