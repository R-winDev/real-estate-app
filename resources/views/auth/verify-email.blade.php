<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-surface-900">تایید ایمیل</h2>
        <p class="text-sm text-surface-500 mt-2">از ثبت نام شما ممنونیم!</p>
    </div>

    <div class="mb-6 text-sm text-surface-600 leading-relaxed">
        لطفاً قبل از شروع، آدرس ایمیل خود را با کلیک روی لینکی که برایتان ایمیل کردیم تایید کنید.
        اگر ایمیل را دریافت نکردید، خوشحال می‌شویم یکی دیگر برایتان ارسال کنیم.
    </div>

    @if (session('status') == 'verification-link-sent')
        <x-alert type="success" class="mb-4">لینک تایید جدید به آدرس ایمیل شما ارسال شد.</x-alert>
    @endif

    <div class="flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-primary btn-sm">
                ارسال مجدد ایمیل تایید
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-surface-500 hover:text-surface-800 font-medium transition-colors">
                خروج
            </button>
        </form>
    </div>
</x-guest-layout>
