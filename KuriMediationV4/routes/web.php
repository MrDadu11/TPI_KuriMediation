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


// Route for displaying the homepage WITHOUT existing meetings
Route::get('/home', [MeetingController::class, 'index'])->name('meeting.index')->middleware(['auth']);
// Route for displaying the homepage WITH existing meetings 
Route::get('/home/{year?}', [MeetingController::class, 'index'])->name('meeting.index')->middleware(['auth']);

// Default route for the user profile's page
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Route for displaying the "about" page
Route::view('about', 'about')
    ->middleware(['auth'])
    ->name('about');

// Route for storing meetings's data into the Database
Route::post('/meeting/store', [MeetingController::class, 'store'])->name('meeting.store')->middleware(['auth']);
// Route for displaying the meeting's information page
Route::get('/meeting/edit/{id}', [MeetingController::class, 'edit'])->name('meeting.edit')->middleware(['auth']);
// Route for deleting a meeting
Route::get('/meeting/destroy/{id}', [MeetingController::class, 'destroy'])->name('meeting.destroy')->middleware(['auth']);
// Route for updating the meeting's informations
Route::put('/meeting/update/{meetingId?}', [MeetingController::class, 'update'])->name('meeting.update')->middleware(['auth']);

require __DIR__.'/auth.php';

