<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ConcernPrioritiesController;
use App\Http\Controllers\ConcernsCommentsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConcernsController;
use App\Http\Controllers\ProvincesController;
use App\Http\Controllers\SystemFeedbackController;
use App\Http\Controllers\DashboardController;
use App\Models\provinces;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Models\concern_priorities;

Route::get('/', function () {
    return view('home');
})->name('home');

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

    // Show User Location form - For User
    Route::get('/register/location','locationRegisterShow')->name('show.register.location');
    // Processes Admin, Government, citizen accounts - For Admin and citizen
    Route::post('/register/location','register')->name('register.location');

    // Create Account Page for Admin
    Route::get('/create/admin','showCreateAccountAdmin')->name('show.admin.create');
    // Handling requests
    Route::post('/create/admin','createAccountAdmin')->name('admin.create');

    // Show User Location form - For Admin
    Route::get('/create/admin/location','locationRegisterShow')->name('show.admin.location');

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
    Route::get('/concern', 'index')->name( 'concern-list');
    Route::get('/concerns/create', 'create')->name('create.concerns');
    Route::post('concerns/create', 'store')->name('store.create');
    Route::get('/concerns/search', 'search')->name('search.concerns');
    Route::get('/concerns/sort', 'sort')->name('sort.concerns');
    Route::post('concerns/delete/{id}', 'deleteConcern')->name('concerns.delete');
});

// Adding Priority
Route::controller(ConcernPrioritiesController::class)->group(function () {
    Route::get('/concerns/priorities/add', 'addPriority')->name('add.priorities');
});

Route::controller(ConcernsCommentsController::class)->group(function  () {
    Route::get('/concerns/{id}/comments', 'index')->name('concerns.comments');
    Route::post('/concerns/{concern}/comments', [ConcernsCommentsController::class, 'store'])
    ->name('concerns.comments.store');

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

Route::middleware(['auth'])->group(function () {
    Route::get('/citizens/profile', [ProfileController::class, 'showProfile'])->name('citizen.profile');
    Route::put('/citizens/profile', [ProfileController::class, 'update'])->name('citizen.profile.update');

    // For Staff
    Route::get('/staff/profile', [ProfileController::class, 'showProfile'])->name('staff.profile');

    // For Admin
    Route::get('/admin/profile', [ProfileController::class, 'showProfile'])->name('admin.profile');
});



// concerns details
Route::get('/citizen/concern/details/{id}', [ConcernsController::class, 'show'])->name('citizens.concerns.details');


//comments 
Route::post('/concerns/{concern}/comment', [ConcernsController::class, 'addComment'])->name('concerns.comment');

Route::get('/concerns/in-progress', action: [ConcernsController::class, 'showInProgress'])->name('staffs.inprogress');
Route::post('/concerns/{concern}/update-status', [ConcernsController::class, 'updateStatus'])->name('concerns.updateStatus');

Route::get('/concerns/resolved', action: [ConcernsController::class, 'showResolved'])->name('staffs.resolved');



// User Profile Routes
Route::get('/concerns', [ConcernsController::class, 'index'])->name('concerns.list');

// Feedback Controller
Route::controller(SystemFeedbackController::class)->group(function () {
    Route::get('/feedback', 'index')->name('feedback');
    // for feedback creation
    Route::get('/feedback/create', 'create')->name('feedback.create');
    Route::post('/feedback', 'store')->name('feedback.store');
    Route::patch('/feedback/update-status/{feedback}', 'updateStatus')->name('feedback.update-status');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route for Admin Controller
Route::controller(AdminController::class)->group(function () {
    Route::get('admin/staff/lists', 'staffList')->name('staff-lists');
});

// Route for Fallback page
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});