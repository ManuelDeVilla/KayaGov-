<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConcernsController;
use App\Http\Controllers\ProvincesController;
use App\Http\Controllers\SystemFeedbackController;
use App\Models\provinces;
use Illuminate\Support\Facades\Route;

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
    // User Profile Routes
    Route::get('/concerns', 'index')->name('concerns.list');
});

Route::controller(ConcernsController::class)->group(function () {
    Route::get('/', 'index')->name('homepage');
    Route::get('/concerns/create', 'create')->name('create.concerns');
    Route::post('concerns/create', 'store')->name('store.create');
    Route::get('/concerns/search', 'search')->name('search.concerns');
    Route::get('/concerns/sort', 'sort')->name('sort.concerns');
});

Route::controller(CityController::class)->group(function () {
    // Used in creating concern
    route::get('/show/cities', 'show')->name('show.create-concern');
    route::get('/search/cities', 'search')->name('search.create-concern');
});

// Getting Province in filter for list of concerns
Route::controller(ProvincesController::class)->group(function () {
    // Used in filters for homepage
    route::get('/list/province', 'listProvince')->name('list.province');
    route::get('/list/search-province', 'searchListProvince')->name('list.search-province');
});


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

// dashboard routes
Route::get('/dashboard', function () {
return view('dashboard');
})->name('dashboard');