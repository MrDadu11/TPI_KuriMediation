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
    <title>KuriBudget - Budget <?php echo $selectedYear->current_year ?></title>
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
                <div class="bg-white inline-flex border rounded-md hover:border-transparent">
                    @if ($years !== 0)
                        @foreach ($years as $year)
                            @if ($year->budget_salary > 0 and $year->user_id == $user->id)
                                <div class="sm:flex shadow-lt border rounded-md py-1 px-2 lg:px-3 hover:bg-slate-200 active:border-black {{ $selectedYear && $selectedYear->current_year == $year->current_year ? 'active-link' : '' }}">
                                    <a href="{{ route('budgets.index', $year->current_year) }}">{{ $year->current_year }}</a>
                                </div>
                            @endif
                        @endforeach                                                     
                    @endif
                    <form action="{{ route('years.create') }}" method="HEAD">
                        @csrf
                        <button>
                            <div class="sm:flex shadow-lt border rounded-md hover:border-black py-1 px-2 lg:px-3 hover:bg-slate-200 transition">
                                +
                            </div>       
                        </button>
                    </form>
                </div>
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 mt-2">
                            {{ __('Budget par catégories') }}
                        </h2>
                    </header>
                    <div class="mt-2 mb-3 font-bold text-black border-b-gray-200 border-b flex justify-between">
                            <h3>Catégories</h3>
                            <h3>Montant</h3>
                    </div>
                    <ul>
                        @foreach ($categories as $category)
                            @php
                                // Retrieve all budgets related to the current category
                                $categoryBudgets = $budgets->where('category_id', $category->id)->where('year_id', $selectedYear->id);
                                // Calculate the sum of all budgets for this category
                                $totalAmount = number_format($categoryBudgets->sum('amount'), 2, '.', '');
                                // dd($selectedYear);
                            @endphp
                            <li class="flex flex-col my-1 border-b border-gray-200">
                                <div class="flex justify-between font-bold">
                                    <div>{{ $category->name }}</div>
                                    <div>{{ $totalAmount }}</div>
                                </div>
                                @if($categoryBudgets->isNotEmpty())
                                    <ul class="border-t-gray-200 border-t">
                                        @foreach ($categoryBudgets as $budget)
                                            <li class="flex justify-between">
                                                <div class="ml-2">{{ $budget->name }}</div>
                                                <div>{{ $budget->amount }}</div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    
                    
                    <div class="flex justify-between font-bold mt-2 border-t-gray-900 border-t">
                        <span>Montant total</span>
                        <span>{{ number_format($budgetTotal, '2', '.', ''). ' CHF' }}</span>
                    </div>
                    <div class="flex justify-between font-bold mt-2 ">
                        <span>Epargne</span>
                        <span>{{ number_format($availableMoney, '2', '.', ''). ' CHF' }}</span>
                    </div>
                </section>
                <div class="flex justify-end mt-2">
                    <a href="{{ route('budgets.create', ['year' => $selectedYear->current_year]) }}" class="inline-block px-4 py-2 ml-2 bg-gray-100 text-black font-medium text-xs leading-tight uppercase rounded shadow-md border hover:bg-green-500 hover:shadow-lg focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                        {{ __('Ajouter un champ') }}
                    </a>                                 
                    <a href="{{ route('budgets.edit', ['year' => $selectedYear->current_year]) }}" class="inline-block px-4 py-2 ml-2 bg-gray-800 text-white font-medium text-xs leading-tight uppercase rounded shadow-md border-transparent border hover:bg-black hover:shadow-lg focus:bg-black focus:shadow-lg focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                        {{ __('Modifier le budget') }}
                    </a>
                    <form action="{{ route('budgets.destroy', ['year' => $selectedYear->current_year]) }}" method="POST">
                        @csrf
                        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer le budget annuel?');" class="inline-block px-4 py-2 ml-2 bg-red-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md border-transparent border hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                            {{ __('Supprimer le budget') }}
                        </button>
                    </form>                              
                </div>
            </div>                             
        </div>
    </div>
</x-app-layout>



</body>
</html>
