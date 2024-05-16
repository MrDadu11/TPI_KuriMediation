<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Year;
use App\Models\Category;
use App\Http\Livewire\AddBudgetForm;





?>

<div class="bg-white inline-flex border rounded-md hover:border-transparent">
    @if ($years !== 0)
        @foreach ($years as $year)
            @if ($year->budget_salary > 0)
                <div class="sm:flex shadow-lt border rounded-md hover:border-black py-1 px-2 lg:px-3 hover:bg-slate-200 transition">
                    <button>{{ $year->current_year }}</button>                                    
                </div>
            @endif
        @endforeach                      
    @endif
    <form action="{{ route('years.create') }}" method="HEAD">
        @csrf
        <div class="sm:flex shadow-lt border rounded-md hover:border-black py-1 px-2 lg:px-3 hover:bg-slate-200 transition">
            <button>+</button> {{-- Redirects to a page --}}
        </div>       
    </form>
</div>


