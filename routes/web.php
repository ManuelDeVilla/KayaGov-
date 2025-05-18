<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ConcernsController;
use App\Http\Controllers\SystemFeedbackController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('homepage');
})->name('homepage');

Route::controller(UserController::class)->group(function() {

    // Get Region
    Route::get('/get-search', 'getShowSelector')->name('get.show.values');
    Route::get('/get-show', 'getSearchSelector')->name('get.search.values');

    // Register Routes
    // Showing register form
    Route::get('/register','showRegister')->name('show.register');
    // Handling requests
    Route::post('/register','register')->name('register');

    // Login Routes
    // Showing login form
    Route::get('/login', 'showLogin')->name('show.login');
    // Handling requests
    Route::post('login', 'login')->name('login');

    // Logout Routes
    Route::get('/logout', 'logout')->name('logout');

// since login and register are not yet ready, hardcode muna
//     // dashboard routes
//     Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard/staff', function () {
//         return view('dashboard.staff');
//     })->name('dashboard.staff');

//     Route::get('/dashboard/citizen', function () {
//         return view('dashboard.citizen');
//     })->name('dashboard.citizen');
// });

// route for hard coded dashboard
Route::get('/dashboard/staff', function () {
    return view('dashboard.staff');
})->name('dashboard.staff');

Route::get('/dashboard/citizen', function () {
    return view('dashboard.citizen');
})->name('dashboard.citizen');


    // User Profile Routes
    Route::get('/concerns', [ConcernsController::class, 'index'])->name('concerns.list');

    // for feedback creation
    Route::get('/feedback/create', [SystemFeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [SystemFeedbackController::class, 'store'])->name('feedback.store');
});

