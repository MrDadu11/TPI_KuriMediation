<div>
    {{-- Button that  --}}
    <button wire:click="toggleForm" class="ml-2 py-2 px-3 rounded-lg border text-white font-extrabold bg-blue-800 hover:bg-blue-600 transition ease-in-out duration-150">
        +
    </button>
    @if ($showForm)
    {{-- Background color --}}
    <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
        <section class="px-16 py-12 md:py-16 md:px-20 bg-white rounded-lg border shadow-lg min-w-full xl:min-w-0 xl:max-w-7xl min-h-screen xl:min-h-0 max-h-screen overflow-auto">
            <button wire:click="toggleForm" class="text-blue-800 font-extrabold text-lg hover:text-black transition ease-in-out duration-300 mb-2 underline">
                Retour
            </button>
            <header>
                <h2 class="text-lg font-medium text-black ">
                    {{ __('Ajouter une nouveau suivi') }}
                </h2>
        
                <p class="mt-1 text-sm text-black ">
                    {{ __("Veuillez insérer les informations ci-dessous") }}
                </p>
            </header>
    
        <form action="{{ route('aftercare.store', ['meetingId' => $currentMeeting->id]) }}" class="xl:mt-2 space-y-4" method="POST">
            @csrf
            @method('POST')
            <div class="flex flex-col xl:flex-row xl:justify-between">
                {{-- Date --}}
                <div>
                    <x-input-label for="aftSchedule" :value="__('Date')" />
                    <x-text-input type="date" id="aftSchedule" name="aftSchedule"/>
                    <x-input-error class="mt-2" :messages="$errors->get('aftSchedule')" />
                </div>

                {{-- Duration --}}
                <div class="flex flex-col justify-end xl:w-1/2">
                    <x-input-label for="aftDuration" :value="__('Durée')" class="w-full"/>
                    <x-text-input type="number" id="aftDuration" name="aftDuration" class="w-full"/>
                    <x-input-error class="mt-2" :messages="$errors->get('aftDuration')" />
                </div>
            </div>
            {{-- Visitor/s --}}
            <div class="flex flex-col">
                <x-input-label for="aftVisitor" :value="__('Nom des intervenants')" />
                <textarea class="rounded-lg border-gray-300 resize-none h-24" id="aftVisitor" name="aftVisitor" required></textarea>
                <x-input-error class="mt-2" :messages="$errors->get('aftVisitor')" />
            </div>
            {{-- Description --}}
            <div class="flex flex-col">
                <x-input-label for="aftDescription" :value="__('Description')" />
                <textarea class="rounded-lg border-gray-300 resize-none h-24" id="aftDescription" name="aftDescription" required></textarea>
                <x-input-error class="mt-2" :messages="$errors->get('aftDescription')" />
            </div>
            {{-- Decision --}}
            <div class="flex flex-col">
                <x-input-label for="aftDecision" :value="__('Decision')" />
                <textarea class="rounded-lg border-gray-300 resize-none h-24" id="aftDecision" name="aftDecision" required></textarea>
                <x-input-error class="mt-2" :messages="$errors->get('aftDecision')" />
            </div>

            {{-- Button for submitting the form --}}
            <div class="flex items-center gap-4">
                <button type="submit" class="py-2 px-2 rounded-lg border bg-blue-800 text-white">Ajouter</button>
            </div>
        </form>
    </section>
    </div>
    @endif
</div>
