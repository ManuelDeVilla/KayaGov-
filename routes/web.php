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
use App\Http\Controllers\concernsCommentsController;

Route::view('/', 'home')->name('landing');

// Route to the homepage
Route::get('/home', function () {
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
    // Creates Admin, Government accounts - For Admin
    Route::post('/register/location','register')->name('register.location');

    // Create Account Page for Admin
    Route::get('/create/admin','showCreateAccountAdmin')->name('show.admin.create');
    // Handling requests
    Route::post('/create/admin','createAccountAdmin')->name('admin.create');

    // Show User Location form - For Admin
    Route::get('/create/admin/location','locationRegisterShow')->name('show.create.admin.location');
    // Creates Admin, Government accounts - For Admin
    Route::post('/create/admin/location','register')->name('create.admin.location');

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

//editing profile
Route::middleware(['auth'])->group(function () {
    Route::get('/citizens/profile', [ProfileController::class, 'showProfile'])->name('citizen.profile.show');
    Route::put('/citizens/profile', [ProfileController::class, 'update'])->name('citizen.profile.update');
});

// concerns details
Route::get('/citizens/concern/details', function () {
    return view('citizens.concerns.details');
})->name('citizens.concerns.details');

//comments 
Route::post('/concerns/{concern}/comment', [ConcernsController::class, 'addComment'])->name('concerns.comment');
Route::post('/concerns/{concern}/comments', [concernsCommentsController::class, 'store'])->name('concerns.comments.store');

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

    // get the user profile
    Route::get('/profile', [UserController::class, 'profile'])->name('user-profile');

    // Government Staff List
    Route::get('/staff-lists', [AdminController::class, 'staffList'])->name('staff_lists.index');
});