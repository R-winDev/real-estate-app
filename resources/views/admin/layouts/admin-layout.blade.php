<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'مدیریت' }} - پنل مدیریت</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-neutral-50 text-neutral-950">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen">

            {{-- Mobile Overlay --}}
            <div x-show="sidebarOpen" x-cloak
                 x-transition:enter="transition-opacity duration-300 ease-out"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity duration-200 ease-in"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 z-40 bg-neutral-950/50 backdrop-blur-sm lg:hidden">
            </div>

            {{-- Sidebar --}}
            @include('admin.partials.sidebar')

            {{-- Main Content Area --}}
            <div class="lg:mr-[240px] min-h-screen flex flex-col">

                {{-- Top Header --}}
                <header class="sticky top-0 z-30 bg-white border-b border-neutral-200">
                    <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">

                        {{-- Right Side: Mobile toggle + Page Title --}}
                        <div class="flex items-center gap-3">
                            <button @click="sidebarOpen = !sidebarOpen"
                                    class="lg:hidden p-2 -mr-2 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5"/>
                                </svg>
                            </button>
                            <div>
                                <h1 class="text-lg font-bold text-neutral-800">{{ $title ?? 'مدیریت' }}</h1>
                            </div>
                        </div>

                        {{-- Left Side: Site link + User dropdown --}}
                        <div class="flex items-center gap-2">
                            <a href="{{ route('home') }}"
                               class="hidden sm:inline-flex items-center gap-1.5 text-sm text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100 transition-colors px-3 py-2 rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                </svg>
                                مشاهده سایت
                            </a>

                            <div class="h-6 w-px bg-neutral-200 hidden sm:block"></div>

                            {{-- User Dropdown --}}
                            <x-dropdown align="left" width="56">
                                <x-slot name="trigger">
                                    <button class="flex items-center gap-2.5 p-1.5 rounded-lg hover:bg-neutral-100 transition-colors">
                                        <div class="w-8 h-8 bg-primary-500 rounded-lg flex items-center justify-center">
                                            <span class="text-white text-xs font-bold">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
                                        </div>
                                        <span class="hidden sm:block text-sm font-medium text-neutral-700">{{ Auth::user()->name }}</span>
                                        <svg class="w-4 h-4 text-neutral-400 hidden sm:block transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                        </svg>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="px-4 py-3 border-b border-neutral-100">
                                        <p class="text-sm font-semibold text-neutral-900">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-neutral-500 mt-0.5" dir="ltr">{{ Auth::user()->email }}</p>
                                    </div>
                                    <div class="py-1.5">
                                        <a href="{{ route('profile.edit') }}"
                                           class="flex items-center gap-2.5 px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 hover:text-neutral-900 transition-colors mx-1.5 rounded-lg">
                                            <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                            </svg>
                                            پروفایل
                                        </a>
                                        <div class="border-t border-neutral-100 my-1 mx-3"></div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                    class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-danger hover:bg-danger-50 transition-colors mx-1.5 rounded-lg">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                                                </svg>
                                                خروج
                                            </button>
                                        </form>
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                </header>

                {{-- Flash Messages & Errors --}}
                <x-flash-message/>
                <x-error-summary/>

                {{-- Page Content --}}
                <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
                    {{ $slot }}
                </main>

            </div>
        </div>
    </body>
</html>
