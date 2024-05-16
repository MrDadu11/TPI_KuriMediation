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
                    <form action="{{ route('years.store')}}" method="POST">
                    @csrf
                    <!-- Year -->
                    <div>
                        <x-input-label for="current_year" :value="__('Année')" />
                        <select name="current_year" class="rounded-md ring-1 ring-black ring-opacity-5">
                            @foreach ($years as $year)
                                @if ($year->budget_salary == null and $year->user_id == $user->id)
                                    <option value="{{ $year->current_year }}">{{ $year->current_year }}</option>                                
                                @endif
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('current_year')" class="mt-2" />
                    </div>
                
                    <!-- Annual Salary -->
                    <!-- Make sure to adjust the input name to match what the controller expects -->
                    <div class="mt-4">
                        <x-input-label for="budget_salary" :value="__('Salaire annuel')" />
                        <x-text-input id="budget_salary" class="block mt-1 w-full" type="number" name="budget_salary" required autocomplete="budget_salary"/>
                        <x-input-error :messages="$errors->get('budget_salary')" class="mt-2" />
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




