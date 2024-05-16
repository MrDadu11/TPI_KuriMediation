<?php
use App\Models\User;
use App\Http\Controllers\BudgetController;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>KuriBudget - Graphiques</title>
</head>
</body>
<x-app-layout>
    <div class="py-12">
        <div class="bg-white shadow-md border sm:mt-2 max-w-7xl mx-auto px-6 sm:px-6 rounded-xl">
            <h1 class="mt-5 font-bold text-lg">Veuillez entrer votre salaire annuel net</h1>
            <div class="flex justify-center sm:py-48">
                    <form action="{{ route('budgets.store', ['year' => $selectedYear]) }}" method="POST">
                    @csrf
                    <!-- Category -->
                    <div>
                        <x-input-label for="category_id" :value="__('Catégories')" />
                        <select name="category_id" class="rounded-md ring-1 ring-black ring-opacity-5">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>                                
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>
                
                    <!-- Name of the budget -->
                    <div class="mt-4">
                        <x-input-label for="name" :value="__('Nom du budget')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required autocomplete="name"/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <!-- Annual Salary -->
                    <div class="mt-4">
                        <x-input-label for="amount" :value="__('Montant')" />
                        <x-text-input id="amount" class="block mt-1 w-full" type="number" step='any' name="amount" required autocomplete="amount"/>
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>
                
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-4" type="submit">
                            {{ __('Ajouter') }}
                        </x-primary-button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
</body>
</html>




