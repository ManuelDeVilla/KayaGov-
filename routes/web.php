<?php

use App\Http\Controllers\UserController;
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
});

