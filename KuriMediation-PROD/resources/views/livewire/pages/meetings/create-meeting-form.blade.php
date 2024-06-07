<?php

use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{

    public $showForm = false;
    public $types;

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }

    public function mount(){
        $this->types = Type::all();
    }
}; ?>
<div>
    {{-- Button that toggles the visibility of the form --}}
    <button wire:click.prevent="toggleForm" class="ml-2 py-2 px-3 rounded-lg border text-white font-extrabold bg-blue-800 hover:bg-blue-600 transition ease-in-out duration-150">
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
                    {{ __('Ajouter une nouvel entretien') }}
                </h2>
                <p class="mt-1 text-sm text-black ">
                    {{ __("Veuillez insérer les informations ci-dessous") }}
                </p>
            </header>
    
        <form action="{{ route('meeting.store') }}" class="xl:mt-2 space-y-4" method="POST">
            @csrf
            {{-- Type --}}
            <div class="flex flex-col">
                <x-input-label for="type_id" :value="__('Type d\'intervention')" />
                <select name="type_id" id="type_id" class="rounded-lg border border-gray-300">
                    @foreach ($this->types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('type_id')" />
            </div>
            {{-- Name --}}
            <div class="flex flex-col">
                <x-input-label for="name" :value="__('Titre de l\'entretien')"/>
                <x-text-input type="text" id="name" name="name"/>
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            {{-- Description --}}
            <div class="flex flex-col">
                <x-input-label for="description" :value="__('Description')" />
                <textarea class="rounded-lg border-gray-300 resize-none h-24" id="description" name="description" required></textarea>
                <x-input-error class="mt-2" :messages="$errors->get('description')" />
            </div>
            {{-- Date --}}
            <div class="flex flex-col">
                <x-input-label for="schedule" :value="__('Date')" />
                <x-text-input type="date" id="schedule" name="schedule"/>
                <x-input-error class="mt-2" :messages="$errors->get('schedule')" />
            </div>
            {{-- Visitor/s --}}
            <div class="flex flex-col">
                <x-input-label for="visitor" :value="__('Nom des intervenants')" />
                <textarea class="rounded-lg border-gray-300 resize-none h-24" id="visitor" name="visitor" required></textarea>
                <x-input-error class="mt-2" :messages="$errors->get('visitor')" />
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
