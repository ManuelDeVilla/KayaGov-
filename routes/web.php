<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConcernsController;
use App\Http\Controllers\SystemFeedbackController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('homepage');
})->name('homepage');

Route::controller(UserController::class)->group(function() {

    // Get dropdown arrows in register
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
    Route::post('/login', 'login')->name('login');

    // Logout Routes
    Route::post('/logout', 'logout')->name('logout');

    // for feedback creation
    Route::get('/feedback/create', [SystemFeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [SystemFeedbackController::class, 'store'])->name('feedback.store');

    // User Profile Routes
    Route::get('/concerns', 'index')->name('concerns.list');
});

Route::controller(ConcernsController::class)->group(function () {
    Route::get('/concerns/create', 'create')->name('create.concerns');
    Route::post('concerns/create', 'store')->name('store.create');
});

// Used in creating concern
Route::controller(CityController::class)->group(function () {
    route::get('/show/cities', 'show')->name('show.create-concern');
    route::get('/search/cities', 'search')->name('search.create-concern');
});

// dashboard routes
Route::get('/dashboard', function () {
return view('dashboard');
})->name('dashboard');