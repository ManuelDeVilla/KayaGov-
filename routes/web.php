<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConcernsController;
use App\Http\Controllers\SystemFeedbackController;
use App\Http\Controllers\DashboardController;
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
    Route::get('/logout', 'logout')->name('logout');

    // User Profile Routes
    Route::get('/concerns', 'index')->name('concerns.list');
});

Route::controller(ConcernsController::class)->group(function () {
    Route::get('/citizens/concerns/create', 'create')->name('citizens.concerns.create');
    Route::post('citizens/concerns/create', 'store')->name('store.create');
});

// Used in creating concern
Route::controller(CityController::class)->group(function () {
    route::get('/show/cities', 'show')->name('show.create-concern');
    route::get('/search/cities', 'search')->name('search.create-concern');
});


//user profile
Route::get('/citizens/user-profile', function () {
    return view('citizens.user-profile');
})->name('user-profile');

// concerns details
Route::get('/citizen/concern/details', function () {
    return view('citizens.concerns.details');
})->name('citizens.concerns.details');

// concerns page
Route::get('/citizens/concerns', [ConcernsController::class, 'index'])->name('citizens.concerns.index');





//create
Route::get('/citizen/concerns/create', function () {
    return view('citizens.concerns.create'); 
})->name('create.concerns');


//comments 
Route::post('/concerns/{concern}/comment', [ConcernsController::class, 'addComment'])->name('concerns.comment');

//pendings concerns
Route::get('/concerns/pending', [ConcernsController::class, 'pending'])->name('concerns.pending');


// User Profile Routes
Route::get('/concerns', [ConcernsController::class, 'index'])->name('concerns.list');

// for feedback creation
Route::get('/feedback/create', [SystemFeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [SystemFeedbackController::class, 'store'])->name('feedback.store');

// Dashboard Routes
Route::get('/dashboard', function () {
    return view('dashboard'); 
})->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
