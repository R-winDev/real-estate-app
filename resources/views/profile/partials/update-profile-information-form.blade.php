<section>
    <header>
        <h2 class="text-lg font-bold text-surface-900">اطلاعات پروفایل</h2>
        <p class="mt-1 text-sm text-surface-500">اطلاعات حساب کاربری و آدرس ایمیل خود را بروزرسانی کنید.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-5 space-y-5">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="'نام و نام خانوادگی'" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="'ایمیل'" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-surface-800">
                        آدرس ایمیل شما تایید نشده است.
                        <button form="send-verification" class="underline text-sm text-brand-600 hover:text-brand-700">
                            برای ارسال مجدد ایمیل تایید اینجا کلیک کنید.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-emerald-600">
                            لینک تایید جدید به آدرس ایمیل شما ارسال شد.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>ذخیره</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-emerald-600">ذخیره شد.</p>
            @endif
        </div>
    </form>
</section>
