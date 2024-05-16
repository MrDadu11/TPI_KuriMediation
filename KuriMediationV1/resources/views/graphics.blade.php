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
    <title>KuriBudget - Graphiques <?php echo $selectedYear->current_year?></title>
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
                                @if ($year->budget_salary > 0 and $year->user_id == auth()->user()->id)
                                    <div class="sm:flex shadow-lt border rounded-md py-1 px-2 lg:px-3 hover:bg-slate-200 active:border-black {{ $selectedYear && $selectedYear->current_year == $year->current_year ? 'active-link' : '' }}">
                                        <a href="{{ route('graphics.index', $year->current_year) }}">{{ $year->current_year }}</a>
                                    </div>
                                @endif
                            @endforeach                                                     
                        @endif
                        </div>
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 mt-2">
                                    {{ __('Budget par catégories') }}
                                </h2>
                            </header>
                            <div class="bg-white border border-gray-300 shadow-lg rounded-md">
                                {!! $chartBars->container() !!}
                            </div>
                            <div class="bg-white border border-gray-300 shadow-lg rounded-md">
                                {!! $chartLines->container() !!}
                            </div>
                            <div class="flex justify-between">
                            <div class="bg-white border border-gray-300 shadow-lg rounded-md">
                                {!! $chartDonuts->container() !!}
                            </div>
                            <div class="bg-white border border-gray-300 shadow-lg rounded-md">
                                {!! $chartPolarArea->container() !!}
                            </div>
                            </div>
                            
                            
                            
                            
                            <div class="flex justify-between font-bold mt-2 border-t-gray-900 border-t">
                        <span>Montant total</span>
                        <span>{{ number_format($costsTotal, '2', '.', ''). ' CHF' }}</span>
                    </div>
                </section>
                    <div class="flex justify-between font-bold mt-2 ">
                        <span>Epargne</span>
                        <span>{{ number_format($moneySave, '2', '.', ''). ' CHF' }}</span>
                    </div>
            </div>                             
        </div>
    </div>
</x-app-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
{!! $chartBars->script() !!}
{!! $chartLines->script() !!}
{!! $chartDonuts->script() !!}
{!! $chartPolarArea->script() !!}
</body>
</html>
