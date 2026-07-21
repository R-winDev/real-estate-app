<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'املاک') }}</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col bg-neutral-50">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white border-b border-neutral-100">
                    <div class="container-wide py-5">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <x-flash-message/>
            <x-error-summary/>

            <main class="flex-1 page-enter">
                {{ $slot }}
            </main>

            <footer class="bg-neutral-950 mt-auto">
                <div class="container-wide">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-12 pt-14 pb-10">
                        <div class="lg:col-span-1">
                            <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 mb-4 group">
                                <div class="w-9 h-9 bg-primary-500 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
                                    <x-application-logo class="h-5 w-auto text-white" />
                                </div>
                                <span class="text-lg font-bold text-white">املاک</span>
                            </a>
                            <p class="text-sm text-neutral-400 leading-7 max-w-xs">
                                جستجو و مدیریت املاک با اطلاعات معتبر و به‌روز
                            </p>
                        </div>

                        <div>
                            <h4 class="text-sm font-semibold text-white mb-4">لینک‌ها</h4>
                            <ul class="space-y-2.5 text-sm">
                                <li><a href="{{ route('home') }}" class="text-neutral-400 hover:text-accent-400 transition-colors">صفحه اصلی</a></li>
                                <li><a href="{{ route('properties.index') }}" class="text-neutral-400 hover:text-accent-400 transition-colors">جستجوی املاک</a></li>
                                @guest
                                    <li><a href="{{ route('login') }}" class="text-neutral-400 hover:text-accent-400 transition-colors">ورود</a></li>
                                    <li><a href="{{ route('register') }}" class="text-neutral-400 hover:text-accent-400 transition-colors">ثبت نام</a></li>
                                @endguest
                            </ul>
                        </div>

                        <div>
                            <h4 class="text-sm font-semibold text-white mb-4">خدمات</h4>
                            <ul class="space-y-2.5 text-sm">
                                <li><a href="{{ route('properties.index') }}" class="text-neutral-400 hover:text-accent-400 transition-colors">خرید ملک</a></li>
                                <li><a href="{{ route('properties.index') }}" class="text-neutral-400 hover:text-accent-400 transition-colors">اجاره ملک</a></li>
                                <li><a href="{{ route('properties.index') }}" class="text-neutral-400 hover:text-accent-400 transition-colors">فروش ملک</a></li>
                            </ul>
                        </div>

                        <div>
                            <h4 class="text-sm font-semibold text-white mb-4">تماس</h4>
                            <ul class="space-y-2.5 text-sm text-neutral-400">
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-neutral-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <a href="mailto:info@example.com" class="hover:text-accent-400 transition-colors" dir="ltr">info@example.com</a>
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-neutral-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <a href="tel:+982112345678" class="hover:text-accent-400 transition-colors" dir="ltr">۰۲۱-۱۲۳۴۵۶۷۸</a>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-neutral-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span>تهران، خیابان نمونه، پلاک ۱۲۳</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="border-t border-neutral-800 py-5 text-center">
                        <p class="text-xs text-neutral-500">&copy; {{ date('Y') }} املاک. تمامی حقوق محفوظ است.</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
