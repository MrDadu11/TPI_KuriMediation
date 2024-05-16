<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use App\Http\Controllers\BudgetController;
use App\Models\Category;
use App\Models\Budget;
?>

<div class="max-w-6xl">
    <section>
        <header">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Budget par catégories') }}
            </h2>
        </header>
        <div class="flex justify-between mt-2 mb-5 text-gray-600 border-b-gray-200 border-b">
            <h3 class="">Catégories</h3>
            <h3 class="">Montant</h3>
        </div>
        <ul class="flex justify-between">
            <div>            
                @foreach ($categories as $category)
                    <li>{{ $category->name }}</li><br>
                @endforeach
            </div>
            <div>
                @if ($budgets !== 0)
                    @foreach ($budgets as $budget)
                        <li class="flex justify-end">{{ $budget->amount }}</li><br>
                    @endforeach                
                @endif
            </div>
        </ul>
    </section>
    <div class="flex justify-end">
        <form action="">
            <x-primary-button class="ms-4">
                {{ __(' un budget') }}
            </x-primary-button>     
        </form>
    </div>
</div>  

