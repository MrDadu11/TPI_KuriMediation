<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Icons for edit and delete --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @vite('resources/css/app.css')
    <title>Administateur : Utilisateurs</title>
    @livewireStyles
</head>
<body>
    <x-app-layout>
            <div class="shadow-xl shadow-gray-300 border md:mt-10 max-w-full md:max-w-7xl mx-auto px-4 py-2 md:px-5 xl:px-7 rounded-xl">
                <div class="p-3 md:p-6">
                    <section>
                        {{-- Meetings list with a search bar, a sorter, and a button for adding a new meeting --}}
                        <div class="flex flex-col p-4 mt-5">
                            <span class="font-bold text-2xl mb-2 text-blue-800">Utilisateurs</span>
                            <div class="overflow-auto rounded-md p-1">
                                @foreach ($users as $user)
                                <a href="{{ route('user.edit', $user->id) }}">
                                    <div class="flex flex-col xl:w-1/3 font-bold border border-gray-300 shadow-lg rounded-md px-3 py-2">
                                        <span class="text-xl text-blue-800">{{ $user->username }}</span>
                                        <span>Prénom: {{ $user->firstname }}</span>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </section>
                </div>
            </div>
    </x-app-layout>
    @livewireScripts
</body>
</html>
