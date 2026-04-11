<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#0a0a0a] text-white">
    <!-- Global Background Glow -->
    <div class="fixed inset-0 -z-10 pointer-events-none">
        <div class="absolute top-[-200px] left-1/2 -translate-x-1/2 w-[900px] h-[900px]
            bg-[#e9c38c]/5 blur-[160px] rounded-full"></div>
    </div>

    <div class="min-h-screen flex flex-col">
        @include('layouts.navigation')

        {{-- Page Heading --}}
        @isset($header)
            <header class="bg-[#0f1115]/80 backdrop-blur border-b border-[#242833]">
                <div class="max-w-7xl mx-auto py-6 px-6">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Page Content --}}
        <main class="flex-1 max-w-7xl w-full mx-auto px-6 py-8">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
