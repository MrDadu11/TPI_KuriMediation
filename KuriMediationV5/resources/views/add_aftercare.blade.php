<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    {{-- Icons for edit and delete --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Meeting</title>
    @livewireStyles
</head>
<body>
    <x-app-layout>
        <div class="bg-white shadow-lt border md:mt-10 max-w-full md:max-w-7xl mx-auto px-12 py-2 md:px-16 xl:px-20 xl:py-6 rounded-xl">
            <section class="flex flex-col">  
                    <header>
                        <h2 class="text-lg font-medium text-black ">
                            {{ __('Ajouter une nouveau suivi') }}
                        </h2>
                
                        <p class="mt-1 text-sm text-black ">
                            {{ __("Veuillez insérer les informations ci-dessous") }}
                        </p>
                    </header>
            
                <form action="{{ route('aftercare.store', $currentMeeting->id) }}" class="xl:mt-2 space-y-4" method="POST">
                    @csrf
                    @method('POST')
                    <div class="flex flex-col xl:flex-row xl:justify-between">
                        {{-- Date --}}
                        <div>
                            <x-input-label for="schedule" :value="__('Date')" />
                            <x-text-input type="date" id="schedule" name="schedule"/>
                            <x-input-error class="mt-2" :messages="$errors->get('schedule')" />
                        </div>
        
                        {{-- Duration --}}
                        <div class="flex flex-col justify-end xl:w-1/2">
                            <x-input-label for="duration" :value="__('Durée')" class="w-full"/>
                            <x-text-input type="number" id="duration" name="duration" class="w-full"/>
                            <x-input-error class="mt-2" :messages="$errors->get('duration')" />
                        </div>
                    </div>
                    {{-- Visitor/s --}}
                    <div class="flex flex-col">
                        <x-input-label for="visitor" :value="__('Nom des intervenants')" />
                        <textarea class="rounded-lg border-gray-300 resize-none h-24" id="visitor" name="visitor" required></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('visitor')" />
                    </div>
                    {{-- Description --}}
                    <div class="flex flex-col">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea class="rounded-lg border-gray-300 resize-none h-24" id="description" name="description" required></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>
                    {{-- Decision --}}
                    <div class="flex flex-col">
                        <x-input-label for="decision" :value="__('Decision')" />
                        <textarea class="rounded-lg border-gray-300 resize-none h-24" id="decision" name="decision" required></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('decision')" />
                    </div>
        
                    {{-- Button for submitting the form --}}
                    <div class="flex justify-between">
                        <a href="{{ url()->previous() }}" class="py-2 px-2 rounded-lg border bg-blue-800 text-white">Retour</a>
                        <button type="submit" class="py-2 px-2 rounded-lg border bg-blue-800 text-white">Ajouter</button>
                    </div>
                </form>
            </section>
        </div>
    </x-app-layout>
    @livewireScripts
</body>
</html>
