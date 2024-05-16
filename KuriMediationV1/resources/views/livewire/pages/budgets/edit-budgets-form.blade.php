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
    <style>
        .active-link {
            border: 2px solid black;
        }
    </style>
</head>
<body>
    <x-app-layout>
        <div class="py-12">
            <div class="bg-white shadow-md border sm:mt-2 max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 rounded-xl">
                <div class="p-3 sm:p-6">
                    <div class="bg-white inline-flex border rounded-md shadow-lt py-1 px-2 font-bold">
                        <?php echo $selectedYear->current_year ?>
                    </div>
                    <div class="max-w-6xl">
                        <form action="{{ route('budgets.update', ['year' => $selectedYear->current_year]) }}" method="POST">
                            @csrf <!-- CSRF Token for protection against cross-site request forgery -->
                            <section>
                                <header>
                                    <h2 class="text-lg font-medium text-gray-900 mt-2">
                                        {{ __('Budget par catégories') }} <!-- Header of the form section -->
                                    </h2>
                                </header>
                                <div class="mt-2 mb-3 font-bold text-black border-b-gray-200 border-b flex justify-between">
                                    <h3>Catégories</h3> <!-- Column header for category names -->
                                    <h3>Montant</h3> <!-- Column header for amount -->
                                </div>
                                <ul>
                                    @foreach ($categories as $category)
                                        @php
                                            // Retrieving budgets for the current category and selected year
                                            $categoryBudgets = $budgets->where('category_id', $category->id)->where('year_id', $selectedYear->id);
                                            // Calculating the total amount of budgets in this category
                                            $totalAmount = number_format($categoryBudgets->sum('amount'), 2, '.', '');
                                        @endphp
                                        <li class="flex flex-col my-1 border-b border-gray-200">
                                            <div class="flex justify-between font-bold">
                                                <div>{{ $category->name }}</div> <!-- Displaying the category name -->
                                                <div>{{ $totalAmount }}</div> <!-- Displaying the total amount for the category -->
                                            </div>
                                            @if($categoryBudgets->isNotEmpty())
                                                <ul class="border-t-gray-200 border-t">
                                                    @foreach ($categoryBudgets as $index => $budget)
                                                        <li class="flex justify-between">
                                                            <!-- Input fields for each budget, indexed to keep track of each entry uniquely -->
                                                            <input type="text" class="rounded-xl p-1 w-56" value="{{ $budget->name }}" name="budgets[{{ $index }}][name]">
                                                            <input type="number" class="rounded-xl p-1 flex text-right" step='any' value="{{ $budget->amount }}" name="budgets[{{ $index }}][amount]">
                                                            <input type="hidden" value="{{ $budget->id }}" name="budgets[{{ $index }}][id]">
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="flex justify-between font-bold mt-2 mb-2 border-t-gray-900 border-t">
                                    <span>Montant total</span> <!-- Label for total amount -->
                                    <span>{{ number_format($budgetTotal, '2', '.', ''). ' CHF' }}</span> <!-- Displaying the total budget amount -->
                                </div>
                            </section>
                            <div class="flex justify-end">
                                <!-- Submit button for the form -->
                                <button type="submit" class="inline-block px-4 py-2 ml-2 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md border hover:bg-green-300 hover:shadow-lg focus:bg-green-300 hover:text-black focus:shadow-lg focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                                    {{ __('Sauvegarder les changements') }}
                                </button>
                            </div>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</body>
</html>
