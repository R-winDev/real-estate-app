<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'مدیریت' }} - پنل مدیریت</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#f8f9fc]">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen flex">
            @include('admin.partials.sidebar')

            <div class="flex-1 flex flex-col min-h-screen lg:mr-0">
                <header class="bg-white/80 backdrop-blur-md border-b border-surface-100 sticky top-0 z-30 shadow-sm">
                    <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center gap-4">
                            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 -mr-2 rounded-xl text-surface-400 hover:text-surface-600 hover:bg-surface-100 transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                            </button>
                            <div>
                                <h1 class="text-lg font-extrabold text-surface-800">{{ $title ?? 'مدیریت' }}</h1>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('home') }}" class="hidden sm:inline-flex items-center gap-1.5 text-sm text-surface-400 hover:text-surface-700 transition-colors px-3 py-1.5 rounded-lg hover:bg-surface-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                بازگشت به سایت
                            </a>
                            <div class="h-6 w-px bg-surface-200 hidden sm:block"></div>
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="flex items-center gap-2.5 p-1.5 rounded-xl hover:bg-surface-50 transition-all duration-200">
                                    <div class="w-8 h-8 bg-gradient-to-br from-brand-500 to-brand-600 rounded-lg flex items-center justify-center shadow-sm shadow-brand-500/20">
                                        <span class="text-white text-xs font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                    <span class="hidden sm:block text-sm font-medium text-surface-700">{{ Auth::user()->name }}</span>
                                    <svg class="w-4 h-4 text-surface-400 hidden sm:block transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 -translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-surface-100 py-1.5 z-50" x-cloak>
                                    <div class="px-4 py-2.5 border-b border-surface-100">
                                        <p class="text-sm font-bold text-surface-900">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-surface-400 mt-0.5">{{ Auth::user()->email }}</p>
                                    </div>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-surface-600 hover:bg-surface-50 hover:text-surface-900 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        پروفایل
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            خروج
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <x-flash-message/>
                <x-error-summary/>

                <main class="flex-1 p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>

                <footer class="border-t border-surface-100 bg-white/50 px-6 py-4">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-surface-400">
                        <span>{{ date('Y') }} &mdash; پنل مدیریت املاک</span>
                        <span>طراحی با <span class="text-brand-500">Laravel</span> و <span class="text-brand-500">Tailwind</span></span>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
