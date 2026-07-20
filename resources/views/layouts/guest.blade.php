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
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-brand-800 via-brand-900 to-surface-900 relative overflow-hidden">
            <!-- Background decoration -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-40 -right-40 w-[500px] h-[500px] bg-brand-400/8 rounded-full blur-3xl animate-float"></div>
                <div class="absolute -bottom-40 -left-40 w-[600px] h-[600px] bg-brand-300/6 rounded-full blur-3xl animate-float-slow"></div>
                <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-brand-500/4 rounded-full blur-3xl animate-float-slower"></div>
                <!-- Grid pattern overlay -->
                <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 32px 32px;"></div>
            </div>

            <div class="relative z-10">
                <a href="/" class="flex items-center gap-3 group">
                    <x-application-logo class="w-12 h-12 fill-current text-white transition-transform duration-300 group-hover:scale-110" />
                </a>
            </div>

            <div class="relative z-10 w-full sm:max-w-md mt-6 px-6 py-8 glass-strong shadow-glass overflow-hidden sm:rounded-3xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
