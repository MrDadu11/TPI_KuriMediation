<?php

use App\Models\User;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    // public string $name = '';
    // public string $decision = '';
    // public string $description = '';
    // public string $duration = '';
    // public string $visitor = '';

    public $showForm = false;
    public $types;

    // public $types = [];

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }

    public function mount(){
        $this->types = Type::all();
    }


}; ?>

<div>
    <button wire:click="toggleForm" class="ml-2 py-2 px-3 rounded-lg border text-white font-extrabold bg-blue-800 hover:bg-blue-600 transition ease-in-out duration-150">
        +
    </button>
    @if ($showForm)
    <section class="absolute top-56 px-80 py-10 -left-4 bg-white rounded-lg border shadow-lg">
        <header>
            <h2 class="text-lg font-medium text-black ">
                {{ __('Ajouter une nouvel entretien') }}
            </h2>
    
            <p class="mt-1 text-sm text-black ">
                {{ __("Veuillez insérer les informations ci-dessous") }}
            </p>
        </header>
    
        <form wire:submit="{{ route('meeting.store') }}" class="mt-6 space-y-6" method="POST">
            @csrf
            {{-- type --}}
            <div>
                <x-input-label for="type" :value="__('Type d\'intervention')" />
                <select name="type" id="type" class="rounded-lg border border-gray-300">
                    @foreach ($this->types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('type')" />
            </div>
            {{-- name --}}
            <div>
                <x-input-label for="name" :value="__('Titre de l\'entretien')" />
                <input type="text" class="rounded-lg border-gray-300" id="name">
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            {{-- description --}}
            <div>
                <x-input-label for="description" :value="__('Description')" />
                <input type="text" class="rounded-lg border-gray-300" id="description">
                <x-input-error class="mt-2" :messages="$errors->get('description')" />
            </div>
            {{-- Date --}}
            <div class="flex flex-col">
                <x-input-label for="schedule" :value="__('Date')" />
                <input type="date" class="rounded-lg border-gray-300" id="schedule">
                <x-input-error class="mt-2" :messages="$errors->get('schedule')" />
            </div>
            {{-- Visitor/s --}}
            <div class="flex flex-col">
                <x-input-label for="visitor" :value="__('Nom des intervenants')" />
                <input type="text" class="rounded-lg border-gray-300" id="visitor">
                <x-input-error class="mt-2" :messages="$errors->get('visitor')" />
            </div>

    
            <div class="flex items-center gap-4">
                <button type="submit" class="py-2 px-2 rounded-lg border bg-blue-800 text-white">Ajouter</button>
            </div>
        </form>
    </section>
    @endif
</div>
