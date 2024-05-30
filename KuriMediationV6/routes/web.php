<?php

use App\Http\Controllers\AftercareController;
use App\Http\Controllers\GraphicController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\DocumentController;
use App\Models\Aftercare;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use Livewire\Livewire;

// Routes for non-authenticated users
Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        if (Auth::check()) {
            return redirect()->route('home');
        } else {
            return redirect()->route('login');
        }
    });

    // Route for the login page
    Route::get('/login', function () {
        return view('livewire.pages.auth.login');
    })->name('login');

});

// Routes for authenticated users
Route::middleware(['auth'])->group(function() {

// Default route for the user profile's page by Breeze
Route::view('profile', 'profile')
->middleware(['auth'])
->name('profile');

// Route for displaying the "about" page
Route::view('about', 'about')
->middleware(['auth'])
->name('about');

// Route for displaying the homepage WITHOUT/WITH existing meetings
Route::get('/home', [MeetingController::class, 'index'])->name('meeting.index')->middleware(['auth']);
Route::get('/home/{year?}', [MeetingController::class, 'index'])->name('meeting.index')->middleware(['auth']);


// Routes for meetings resource and some custom CRUD methods
Route::put('/meeting/update/{meetingId?}', [MeetingController::class, 'update'])->name('meeting.update')->middleware(['auth']);
Route::get('/meeting/destroy/{id}', [MeetingController::class, 'destroy'])->name('meeting.destroy')->middleware(['auth']);
Route::resource('meeting', MeetingController::class)->except('index', 'update', 'destroy');

Route::post('/upload/{meetingId?}', [DocumentController::class, 'upload'])->name('document.upload');


// Routes for aftercare resource and store, destroy methods
Route::post('/aftercare/store/{meetingId}', [AftercareController::class, 'store'])->name('aftercare.store')->middleware(['auth']);
Route::get('/aftercare/destroy/{aftercareId}', [AftercareController::class, 'destroy'])->name('aftercare.destroy')->middleware(['auth']);
Route::resource('aftercare', AftercareController::class)->except('store', 'destroy');

// Route that shows the graphics page
Route::get('/graphics/{year?}', [GraphicController::class, 'index'])->name('graphic.index')->middleware(['auth']);

});



require __DIR__.'/auth.php';

