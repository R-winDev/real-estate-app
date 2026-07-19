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
        <div class="min-h-screen bg-surface-50">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white/60 backdrop-blur-sm border-b border-surface-100">
                    <div class="container-wide py-5">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <x-flash-message/>
            <x-error-summary/>

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
