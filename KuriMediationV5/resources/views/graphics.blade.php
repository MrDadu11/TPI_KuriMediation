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
    <title>KuriMediation - Graphiques</title>
</head>
<body>
    <x-app-layout>
        <div class="bg-white shadow-lt border md:mt-10 max-w-full md:max-w-7xl mx-auto px-4 py-2 md:px-5 xl:px-7 rounded-xl">
            <div class="p-3 sm:p-6">
                <div class="bg-white inline-flex border rounded-md hover:border-transparent">
                    {{-- Selector for the year --}}
                    <select onchange="location = this.value;" class="rounded-lg border-gray-300 shadow-md">
                        @foreach ($years as $year)
                            <option value="{{ route('graphic.index', $year->year) }}" {{ $currentYear == $year->year ? 'selected' : '' }}>
                                {{ $year->year }}
                            </option>
                        @endforeach
                    </select>
                    </div>
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 mt-2">
                                {{ __('Graphiques par types') }}
                            </h2>
                        </header>
                        <div class=" border border-gray-300 shadow-lg rounded-md p-10">
                            {!! $chartCheeseMonthly->container() !!}
                        </div>
                </section>
            </div>                             
        </div>
    </x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {!! $chartCheeseMonthly->script() !!}
</body>
</html>
