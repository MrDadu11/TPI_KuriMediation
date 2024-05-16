<?php

use App\Http\Controllers\BudgetController;
use App\Http\Controllers\GraphicsController;
use App\Http\Controllers\YearController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login');
        }
    });

    Route::get('/login', function () {
        return view('livewire.pages.auth.login');
    })->name('login');

});




Route::view('dashboard', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');

// Route de base de la page de profile inclue avec Laravel Breeze
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('about', 'about')
    ->middleware(['auth', 'verified'])
    ->name('about');






require __DIR__.'/auth.php';

