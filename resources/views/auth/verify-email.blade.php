<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-surface-900">تایید ایمیل</h2>
    </div>

    <div class="mb-4 text-sm text-surface-600 leading-relaxed">
        از ثبت نام شما ممنونیم! لطفاً قبل از شروع، آدرس ایمیل خود را با کلیک روی لینکی که برایتان ایمیل کردیم تایید کنید. اگر ایمیل را دریافت نکردید، خوشحال می‌شویم یکی دیگر برایتان ارسال کنیم.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            لینک تایید جدید به آدرس ایمیلی که هنگام ثبت نام وارد کردید ارسال شد.
        </div>
    @endif

    <div class="mt-6 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div>
                <x-primary-button>
                    ارسال مجدد ایمیل تایید
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-surface-600 hover:text-surface-900 underline">
                خروج
            </button>
        </form>
    </div>
</x-guest-layout>
