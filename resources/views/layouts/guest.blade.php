<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'املاک') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-primary-800 via-primary-900 to-primary-950 relative overflow-hidden">
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-40 -right-40 w-[500px] h-[500px] bg-accent-400/5 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-40 -left-40 w-[600px] h-[600px] bg-primary-400/8 rounded-full blur-3xl"></div>
                <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 32px 32px;"></div>
            </div>

            <div class="relative z-10">
                <a href="/" class="flex flex-col items-center gap-3 group">
                    <div class="w-12 h-12 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/10 group-hover:bg-white/20 transition-all duration-300">
                        <x-application-logo class="h-7 w-auto text-white" />
                    </div>
                    <span class="font-bold text-white text-lg">املاک</span>
                </a>
            </div>

            <div class="relative z-10 w-full sm:max-w-md mt-6 px-6 py-8 bg-white/10 backdrop-blur-xl border border-white/15 rounded-2xl shadow-2xl shadow-black/20 overflow-hidden">
                {{ $slot }}
            </div>

            <div class="relative z-10 mt-6 text-center">
                <a href="{{ route('home') }}" class="text-sm text-primary-200/60 hover:text-primary-200 transition-colors duration-200 flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    بازگشت به صفحه اصلی
                </a>
            </div>
        </div>
    </body>
</html>
