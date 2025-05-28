<?php


use App\Http\Controllers\CityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConcernsController;
use App\Http\Controllers\ProvincesController;
use App\Http\Controllers\SystemFeedbackController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
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

    // User Profile Routes
    Route::get('/concerns', 'index')->name('concerns.list');
});

Route::controller(ConcernsController::class)->group(function () {
    Route::get('/', 'index')->name('homepage');
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

//editing profile
Route::middleware(['auth'])->group(function () {
    Route::get('/citizens/profile', [ProfileController::class, 'showProfile'])->name('citizen.profile.show');
    Route::put('/citizens/profile', [ProfileController::class, 'update'])->name('citizen.profile.update');
});

// concerns details
Route::get('/citizen/concern/details', function () {
    return view('citizens.concerns.details');
})->name('citizens.concerns.details');

// concerns page
Route::get('/citizens/concerns', [ConcernsController::class, 'index'])->name('citizens.concerns.index');

//comments 
Route::post('/concerns/{concern}/comment', [ConcernsController::class, 'addComment'])->name('concerns.comment');

//pendings concerns
Route::get('/concerns/pending', [ConcernsController::class, 'pending'])->name('concerns.pending');

// for feedback creation
Route::get('/feedback/create', [SystemFeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [SystemFeedbackController::class, 'store'])->name('feedback.store');

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/citizen-dashboard', [DashboardController::class, 'citizenDashboard'])->name('citizens.dashboard');
    Route::get('/staff-dashboard', [DashboardController::class, 'staffDashboard'])->name('staffs.dashboard');

    // Concerns routes (consolidated)
    Route::get('/concerns/create', [ConcernsController::class, 'create'])->name('concerns.create');
    Route::post('/concerns/create', [ConcernsController::class, 'store'])->name('store.create');
    Route::get('/concerns/{id}', [ConcernsController::class, 'show'])->name('concerns.show');
    
    // Citizen specific routes
    Route::prefix('citizens')->name('citizens.')->group(function () {
        Route::get('/concerns/{id}', [ConcernsController::class, 'show'])->name('concerns.details');
    });
});

// Public concern creation route (if you want non-authenticated users to create concerns)
Route::get('/concerns/create', [ConcernsController::class, 'create'])->name('create.concerns');
Route::post('/concerns/create', [ConcernsController::class, 'store'])->name('store.create');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/staff/verify/{id}', [AdminController::class, 'verifyStaff'])->name('verify.staff');
    Route::post('/staff/reject/{id}', [AdminController::class, 'rejectStaff'])->name('reject.staff');
    Route::delete('/concern/{id}', [AdminController::class, 'deleteConcern'])->name('concern.delete');
    
    // System Feedback Routes (moved inside admin group)
    Route::get('/system-feedbacks', [SystemFeedbackController::class, 'index'])->name('system-feedbacks.index');
    Route::patch('/system-feedbacks/{feedback}/status', [SystemFeedbackController::class, 'updateStatus'])->name('system-feedbacks.update-status');

});