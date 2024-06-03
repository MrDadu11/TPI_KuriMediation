<?php

use App\Http\Controllers\AftercareController;
use App\Http\Controllers\GraphicController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Routes for non-authenticated users
Route::middleware(['guest'])->group(function () {
        Route::get('/', function () {
        if (Auth::check()) {
                return redirect()->route('meeting.index');
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
        Route::get('/home', [MeetingController::class, 'index'])
                ->name('meeting.index')
                ->middleware(['auth']);
        Route::get('/home/{year?}', [MeetingController::class, 'index'])
                ->name('meeting.index')
                ->middleware(['auth']);
        Route::post('/meeting/update/{meetingId}', [MeetingController::class, 'update'])
                ->name('meeting.update')
                ->middleware(['auth']);
        Route::get('/meeting/destroy/{meetingId}', [MeetingController::class, 'destroy'])
                ->name('meeting.destroy')
                ->middleware(['auth']);
        Route::resource('meeting', MeetingController::class)
                ->except('index', 'update', 'destroy');

        // Routes for the uploading, displaying and deleting the document
        Route::post('/document/upload/{meetingId}', [DocumentController::class, 'upload'])
                ->name('document.upload')
                ->middleware(['auth']);
        Route::get('/document/show/{meetingId}/{fileName}', [DocumentController::class, 'show'])
                ->name('document.show')
                ->middleware(['auth']);
        Route::get('/document/destroy/{meetingId}/{fileName}', [DocumentController::class, 'destroy'])
                ->name('document.destroy')
                ->middleware(['auth']);


        // Routes for aftercare resource and store, destroy methods
        Route::get('/aftercare/create/{meetingId}', [AftercareController::class, 'create'])
                ->name('aftercare.create')
                ->middleware(['auth']);
        Route::post('/aftercare/store/{meetingId}', [AftercareController::class, 'store'])
                ->name('aftercare.store')
                ->middleware(['auth']);
        Route::get('/aftercare/edit/{meetingId}', [AftercareController::class, 'edit'])
                ->name('aftercare.edit')
                ->middleware(['auth']);
        Route::put('/aftercare/update/{meetingId}', [AftercareController::class, 'update'])
                ->name('aftercare.update')
                ->middleware(['auth']);
        Route::get('/aftercare/destroy/{aftercareId}', [AftercareController::class, 'destroy'])
                ->name('aftercare.destroy')
                ->middleware(['auth']);
        Route::resource('aftercare', AftercareController::class)
                ->except('store', 'create', 'edit', 'update', 'destroy');

        // Route that shows the graphics page
        Route::get('/graphics/{year?}', [GraphicController::class, 'index'])
                ->name('graphic.index')
                ->middleware(['auth']);

        // START : Admin pages

        // Routes for user
        Route::get('/admin/users', [UserController::class, 'index'])
                ->name('user.index')
                ->middleware(['auth']);
        Route::get('/admin/users/edit/{userId}', [UserController::class, 'edit'])
                ->name('user.edit')
                ->middleware(['auth']);
        Route::post('/admin/users/update/{userId}', [UserController::class, 'update'])
                ->name('user.update')
                ->middleware(['auth']);
        Route::get('/admin/users/destroy/{userId}', [UserController::class, 'destroy'])
                ->name('user.destroy')
                ->middleware(['auth']);

        // Routes for type
        Route::get('/admin/types', [TypeController::class, 'index'])
                ->name('type.index')
                ->middleware(['auth']);
        Route::get('/admin/types/edit/{typeId}', [TypeController::class, 'edit'])
                ->name('type.edit')
                ->middleware(['auth']);
        Route::post('/admin/types/store', [TypeController::class, 'store'])
                ->name('type.store')
                ->middleware(['auth']);
        Route::post('/admin/types/update/{typeId}', [TypeController::class, 'update'])
                ->name('type.update')
                ->middleware(['auth']);
        Route::get('/admin/types/destroy/{typeId}', [TypeController::class, 'destroy'])
                ->name('type.destroy')
                ->middleware(['auth']);

        // END : Admin page

});



require __DIR__.'/auth.php';

