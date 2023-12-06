<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite('resources/css/app.css')
    </head>

    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-center bg-[#5576be] selection:text-white">
            <img class="absolute h-[80%] w-[80%] opacity-[0.05] z-10" src="bgIcon.svg"/>
            <div class="flex flex-col items-center mb-20 z-50">
                <span class="text-7xl text-center text-slate-300 text-shadow shadow-gray-700">Welcome to Bookme!</span>
                <div class="mt-10 p-6 text-center">
                    @auth
                        <div class="flex flex-col items-center">
                            <span class="text-xl text-slate-300 text-shadow shadow-gray-700">If you are login you can use the Home button to use Bookme.</span>
                            <a href="{{ url('/posts') }}" class="mt-11 text-2xl font-semibold text-slate-300 hover:text-white dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-slate-500">Home</a>
                        </div>
                    @else
                        <div class="flex flex-col items-center">
                            <span class="text-xl text-slate-300 text-shadow shadow-gray-700">Post message on your or friends feed and discuss about anything with them</span>
                            <span class="text-xl text-slate-300 text-shadow shadow-gray-700">If you dont have an account please register.</span>
                        </div>
                        <div class="flex justify-center mt-11 gap-48">
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="text-2xl font-semibold text-slate-300 text-shadow shadow-gray-700 hover:text-white dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-slate-500">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-2xl font-semibold text-slate-300 text-shadow shadow-gray-700 hover:text-white dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-slate-500">Register</a>
                            @endif
                        </div>
                    @endauth
                    </div>
                @endif
            </div>
        </div>
    </body>
</html>
