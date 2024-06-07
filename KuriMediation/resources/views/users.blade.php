<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Icons for edit and delete --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @vite('resources/css/app.css')
    <title>Administateur : Utilisateurs</title>
</head>
<body>
    <x-app-layout>
            <div class="shadow-xl shadow-gray-300 border md:mt-10 max-w-full md:max-w-7xl mx-auto px-4 py-2 md:px-5 xl:px-7 rounded-xl">
                <div class="p-3 md:p-6">
                    <section>
                        <a href="{{ route('meeting.index') }}" class="text-blue-800 font-extrabold text-xl underline hover:text-black transition ease-in-out duration-300">
                            Retour
                        </a>
                        <div class="flex flex-col p-4 mt-5">
                            <span class="font-bold text-2xl mb-2 text-blue-800">Utilisateurs</span>
                            <div class="rounded-md p-1">
                                {{-- List of users except for the current user --}}
                                @foreach ($users as $user)
                                    @if ($user->id !== Auth::id())
                                        <div class="flex items-center justify-between xl:w-1/3 font-bold border border-gray-300 shadow-lg rounded-md px-3 py-2">
                                            <a href="{{ route('user.edit', $user->id) }}" class="flex flex-col flex-1">
                                                <span class="text-xl text-blue-800">{{ $user->username }}</span>
                                                <span>Prénom: {{ $user->firstname }}</span>
                                            </a>                               
                                            <div>
                                                <a href="{{ route('user.destroy', $user->id) }}" onclick="return confirm('Voulez-vous supprimer cet utilisateur?');"><i class="fa fa-trash fa-lg"></i></a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </section>
                </div>
            </div>
    </x-app-layout>
</body>
</html>
