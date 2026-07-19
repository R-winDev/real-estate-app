<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'املاک') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-brand-700 via-brand-800 to-brand-950 relative overflow-hidden">
            <!-- Background decoration -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-brand-400/10 rounded-full blur-3xl animate-float"></div>
                <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-brand-300/10 rounded-full blur-3xl animate-float-slow"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-brand-500/5 rounded-full blur-3xl"></div>
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
