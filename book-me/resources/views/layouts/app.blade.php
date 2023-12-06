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
    <body class="font-sans antialiased">
        <div class="h-full ">
            @include('layouts.navigation')
            <div class="flex-1 flex-row mt-20 w-full">
                @include('layouts.sidebar')
                <!-- Page Content -->
                <main class="fixed h-[calc(100%-5rem)] ml-[20%] w-[80%] overflow-y-scroll bg-[#93c1e9] bg-opacity-40 dark:bg-gray-900">
                    @if (request()->routeIs('friends.*'))
                        @include('layouts.nav-friends')
                    @endif
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
