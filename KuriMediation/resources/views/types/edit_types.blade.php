
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    {{-- Icons for edit and delete --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Modifier</title>
</head>
<body>
    <x-app-layout>
        <div class="bg-white border md:mt-10 max-w-full md:max-w-7xl mx-auto px-4 py-2 md:px-5 xl:px-10 xl:py-8 rounded-xl">
            <a href="{{ route('type.index') }}" class="bg-blue-800 text-white border px-3 py-2 rounded-lg font-extrabold text-lg hover:bg-blue-600 transition ease-in-out duration-300">
                Retour
            </a>
            <div class="px-5 py-4 border rounded-lg shadow-xl mt-3">
                <div class="text-2xl text-blue-800 font-bold">Modification du type : {{ $currentType->name }}</div>
                {{-- Form that updates the type's name --}}
                <form action="{{ route('type.update', $currentType->id) }}" method="POST" class="flex justify-center p-8">
                    @csrf
                    <div class="xl:w-1/3">
                            <label class="text-xl text-blue-800 font-bold text-center" for="name">Nouveau nom du type</label>
                            <input type="text" class="rounded-lg border-gray-200 resize-none w-full" id="name" name="name" placeholder="Nom du type" value="{{ $currentType->name }}" required>
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            <div class="flex justify-center items-center mt-2">
                                <button type="submit" class="rounded-lg px-3 py-1 bg-blue-800 text-white hover:bg-blue-600 h-10 items-center transition ease-in-out duration-150">Sauvegarder</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </x-app-layout>
</body>
</html>
