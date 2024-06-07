<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    {{-- Icons for edit and delete --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Modifier suivi : {{ $currentAftercare->name }}</title>
    @livewireStyles
</head>
<body>
    <x-app-layout>
        <div class="bg-white shadow-lt border md:mt-10 max-w-full md:max-w-7xl mx-auto px-4 py-2 md:px-5 xl:px-10 xl:py-6 rounded-xl">
            <section>
                <form action="{{ route('aftercare.update', $currentAftercare->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="px-5 py-3 border rounded-lg shadow-md">                 
                        <div class="flex justify-between space-x-2">
                            <div>
                                <span class="font-bold text-blue-800 text-lg">Suivi du</span>
                                <span class="font-bold text-blue-800 text-lg">{{ \Carbon\Carbon::parse($currentAftercare->schedule)->format('m.d.Y') }}</span>
                            </div>
                            <div>
                                <span class="font-bold text-blue-800 text-lg">Nom de l'entretien:</span>
                                <span class="font-bold text-blue-800 text-lg">{{ $currentMeeting->name }}</span>
                            </div>

                        </div>
                        <div class="mt-2 flex flex-col xl:flex-row justify-between">
                            <div class="w-3/5">
                                {{-- Visitor --}}
                                <div>
                                    <x-input-label for="visitor" :value="__('Intervenants')" />
                                    <textarea class="rounded-lg border-gray-200 resize-none w-full" id="visitor" name="visitor" placeholder="Entrez le nom des intervenants" required>{{ $currentAftercare->visitor }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('visitor')" />
                                </div>
                                {{-- Description --}}
                                <div>
                                    <x-input-label for="description" :value="__('Description')" />
                                    <textarea class="rounded-lg border-gray-200 resize-none w-full" id="description" name="description" placeholder="Entrez les données" required>{{ $currentAftercare->description }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                                </div>
                                {{-- Decision --}}
                                <div>
                                    <x-input-label for="decision" :value="__('Decision')" />
                                    <textarea class="rounded-lg border-gray-200 resize-none w-full" id="decision" name="decision" placeholder="Entrez les données" required>{{ $currentAftercare->decision }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('decision')" />
                                </div>
                            </div>
                            <div class="flex flex-col xl:flex-row xl:space-x-2">
                                <div class="flex flex-col justify-center items-center xl:flex-row xl:">
                                    {{-- Duration --}}
                                    <x-input-label for="duration" :value="__('Durée:')" />
                                    <input type="number" min="1" max="3600" class="rounded-lg border-gray-200 resize-none ml-2" id="duration" name="duration" placeholder="0" value="{{ $currentAftercare->duration }}" required/>
                                    <x-input-error class="mt-2" :messages="$errors->get('duration')" />
                                </div>
                                <div class="flex justify-center items-center mt-2 xl:mt-0 xl:justify-end xl:items-end">
                                    <button type="submit" class="rounded-lg px-3 py-1 bg-blue-800 text-white h-10 items-center">Sauvegarder</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>        
    </x-app-layout>
    @livewireScripts
</body>
</html>
