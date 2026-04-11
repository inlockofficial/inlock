<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'INLOCK') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#0f1115] text-white">

    <div class="min-h-screen flex flex-col justify-center items-center px-6">

        <!-- Logo -->
        <a href="/" class="mb-10">
            <x-application-logo
                class="w-16 h-16 fill-current text-[#e9c38c] hover:scale-105 transition" />
        </a>

        <!-- Auth Card -->
        <div class="
            w-full sm:max-w-md
            bg-[#171a21]
            border border-[#242833]
            rounded-2xl
            shadow-2xl
            p-8
        ">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <p class="mt-8 text-xs text-gray-500">
            © {{ date('Y') }} INLOCK — Shop globally from Algeria
        </p>

    </div>

</body>
</html>