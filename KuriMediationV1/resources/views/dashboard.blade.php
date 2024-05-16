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
    <title>KuriBudget - Accueil</title>
    <style>
    .active-link {
        border: 2px solid black;
    }

    </style>
</head>
<body>
    <x-app-layout>
        <div class="sm:py-12">
            <div class="bg-white shadow-md border sm:mt-2 max-w-7xl mx-auto px-4 py-2 sm:px-5 lg:px-7 rounded-xl">
                <div class="p-3 sm:p-6">
                    <div class="bg-white inline-flex border rounded-md shadow-md font-bold px-2 py-1">
                        <?php echo $selectedYear->current_year ?>
                    </div>
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 mt-2">
                                {{ __('Budget de l\'année en cours') }}
                            </h2>
                        </header>
                        <div class="bg-white border border-gray-300 shadow-sm hover:shadow-lg rounded-md transition ease-in-out duration-150">
                            {!! $chartBars->container() !!}
                        </div>
                        <div class="sm:flex justify-between mt-1">
                            <div class="px-4 py-2 bg-white border border-gray-300 shadow-sm hover:shadow-lg rounded-md transition ease-in-out duration-150 w-2/4">
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
                                        <span>{{ number_format($costsTotal, '2', '.', ''). ' CHF' }}</span>
                                    </div>
                                    <div class="flex justify-between font-bold mt-2 ">
                                        <span>Epargne</span>
                                        <span>{{ number_format($moneySave, '2', '.', ''). ' CHF' }}</span>
                                    </div>
                                </section>
                            </div>
                            <div class="px-4 py-2 bg-white border border-gray-300 shadow-sm hover:shadow-lg rounded-md transition ease-in-out duration-150 w-2/4">
                                {!! $chartDonuts->container() !!}
                            </div>
                        </div>
                    </section>
                </div>                             
            </div>
        </div>
    </x-app-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
{!! $chartBars->script() !!}
{!! $chartDonuts->script() !!}
</body>
</html>
