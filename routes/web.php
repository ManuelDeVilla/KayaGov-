<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConcernsController;
use App\Http\Controllers\ProvincesController;
use App\Http\Controllers\SystemFeedbackController;
use App\Http\Controllers\DashboardController;
use App\Models\provinces;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function() {

    // Get dropdown arrows in register
    Route::get('/get-search', 'getShowSelector')->name('get.show.values');
    Route::get('/get-show', 'getSearchSelector')->name('get.search.values');

    // Register Routes
    // Showing register form
    // Create Citizen Accounts
    Route::get('/register','showRegister')->name('show.register');
    // Handling requests
    Route::post('/register','register')->name('register');

    // Show User Location form - For Admin
    Route::get('/register/location','locationRegisterShow')->name('show.register.location');
    // Creates Admin, Government accounts - For Admin
    Route::post('/register/location','register')->name('register.location');

    // Creating Staff Accounts
    Route::get('/create/staff','showRegisterStaff')->name('show.staff.register');
    Route::post('/create/staff','registerStaff')->name('staff.register');

    // Location Part of the form
    Route::get('/staff/register/location','locationStaffRegisterShow')->name('staff.show.register.location');
    Route::post('/staff/register/location','registerStaff')->name('staff.register.location');

    // Upload Files
    Route::get('/staff/register/coe','coeUpload')->name('staff.show.register.coe');
    Route::post('/staff/register/coe','registerStaff')->name('staff.register.coe');
    
    // Waiting page of Staffs After 
    Route::get('/staff/waiting','staffWaitingPage')->name(name: 'staff.waiting-page');

    // Creating admin and staff account, only for ADMIN
    Route::prefix('admin')->group(function () {
        // Showing register form for creating staff and admin
        Route::get('/register','showAccountForm')->name('show.create-account');
        // Showing register form for creating staff and admin
        Route::post('/register','register')->name('create-account');

        // For Staff Verification
        Route::get('staff-verification', 'listStaffVerification')->name('list.staff-verification');
        // Verifies the account
        Route::post('staff-verification', 'staffVerification')->name('submit.verification');
    });

    // Login Routes
    // Showing login form
    Route::get('/login', 'showLogin')->name('show.login');
    // Handling requests
    Route::post('/login', 'login')->name('login');

    // Logout Routes
    Route::post('/logout', 'logout')->name('logout');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(ConcernsController::class)->group(function () {
    Route::get('/concern', 'index')->name('concern-list');
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



//user profile
Route::get('/citizens/user-profile', function () {
    return view('citizens.user-profile');
})->name('user-profile');

// concerns details
Route::get('/citizen/concern/details', function () {
    return view('citizens.concerns.details');
})->name('citizens.concerns.details');

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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
