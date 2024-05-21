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
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex-col flex px-6 py-6 bg-white">
            {{-- Login and Register buttons --}}
            <div class="flex justify-between">
                <div>
                    <p class="text-2xl font-bold text-blue-800">KuriMediation</p>
                </div>
                <div>
                    <a href="{{ route('login') }}">
                        <div class="inline-flex ml-2 items-center px-4 py-2 bg-blue-800 border border-gray-900 rounded-md font-semibold text-xs text-white  uppercase tracking-widest hover:bg-blue-600  focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Connexion') }}
                        </div>
                    </a>
                    <a href="{{ route('register') }}">
                        <div class="inline-flex ml-2 items-center px-4 py-2 bg-slate-100 border border-gray-900 rounded-md font-semibold text-xs text-black  uppercase tracking-widest hover:bg-blue-800  focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('S\'inscrire') }}
                        </div>
                    </a>
                </div>

            </div>
            <div class="flex flex-col flex-grow justify-center items-center">
                <div class="w-full sm:max-w-md px-6 py-4 bg-white">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
