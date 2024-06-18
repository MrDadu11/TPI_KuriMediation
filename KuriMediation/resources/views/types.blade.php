<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Icons for edit and delete --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @vite('resources/css/app.css')
    <title>Administateur : Types</title>
</head>
<body>
    <x-app-layout>
        <div class="shadow-2xl bg-gray-200 border-gray-300 border md:mt-10 max-w-full md:max-w-7xl mx-auto px-4 py-2 md:px-5 xl:px-7 rounded-xl">
            <div class="p-3 md:p-6">
                    <section>
                        <div class="flex flex-col items-center p-4 mt-5">
                            {{-- Displays the error if there are --}}
                            @if(session('error'))
                            <div class="font-bold text-red-600">{{ session('error') }}</div>                                    
                            @endsession
                            <span class="font-bold text-2xl mb-2 text-blue-800 text-center">Types</span>
                            <div class="rounded-md p-1 flex flex-col xl:w-1/3">
                                {{-- List of types --}}
                                @foreach ($types as $type)
                                <div class="flex items-center">
                                    <div class="text-xl text-blue-800 font-bold border border-gray-300 shadow-lg rounded-md px-3 py-2 mr-3 w-full text-center">{{ $type->name }}</div>
                                    <div class="flex space-x-2">
                                        {{-- Link that goes to the editing page of the type --}}
                                        <a href="{{ route('type.edit', $type->id) }}"><i class="fa fa-edit fa-lg"></i></a>
                                        {{-- Link that deletes the type --}}
                                        <a href="{{ route('type.destroy', $type->id) }}" onclick="return confirm('Voulez-vous supprimer ce type?');"><i class="fa fa-trash fa-lg"></i></a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            {{-- Form for adding a new type --}}
                            <form action="{{ route('type.store') }}" class="flex flex-col mt-5 space-y-3" method="POST">
                                @csrf
                                @method('POST')
                                <label for="name" class="text-blue-800 font-bold text-xl text-center">Ajouter un type</label>
                                <input type="text" class="px-3 py-2 rounded-lg" placeholder="Nouveau type" id="name" name="name">
                                <button class="bg-blue-800 text-white px-3 py-2 rounded-lg">Confirmer</button>                          
                            </form>
                        </div>
                    </section>
                </div>
            </div>
    </x-app-layout>
</body>
</html>
