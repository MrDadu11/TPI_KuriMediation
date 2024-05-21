<?php

use App\Http\Controllers\MeetingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use Livewire\Livewire;

Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        if (Auth::check()) {
            return redirect()->route('home');
        } else {
            return redirect()->route('login');
        }
    });

    Route::get('/login', function () {
        return view('livewire.pages.auth.login');
    })->name('login');

});

Route::view('graphics', 'graphics')
    ->middleware(['auth'])
    ->name('graphics.index');



Route::get('/home', [MeetingController::class, 'index'])->name('meeting.index')->middleware(['auth', 'verified']);

// Route de base de la page de profile inclue avec Laravel Breeze
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('about', 'about')
    ->middleware(['auth', 'verified'])
    ->name('about');


Route::post('meeting.store', [MeetingController::class, 'store'])->name('meeting.store')->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';

