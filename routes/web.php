<?php
use Illuminate\Support\Facades\Route;



//superadmin Controllers
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\Admin\UserController as AdminUserController;


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\OnboardingController;



// Guest Routes
Route::get('/privacy-policy', function () {
    return view('consent.policy');
})->name('policy');

Route::get('/terms-and-conditions', function () {
    return view('consent.terms');
})->name('terms');

Route::get('/', function () {
    return file_get_contents(public_path('landing/index.html'));
})->name('home');


// Onboarding routes - must be authenticated
Route::middleware(['auth', 'onboarding'])->group(function () {
    Route::prefix('onboarding')->name('onboarding.')->group(function () {
        Route::get('/', [OnboardingController::class, 'index'])->name('index');
        Route::get('/data', [OnboardingController::class, 'getData'])->name('data');
        Route::post('/step-one', [OnboardingController::class, 'saveStepOne'])->name('step-one');
        Route::post('/step-two', [OnboardingController::class, 'saveStepTwo'])->name('step-two');
        Route::post('/complete', [OnboardingController::class, 'complete'])->name('complete');
    });
});


Route::middleware(['auth', 'verified', 'onboarding'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/business/settings', [BusinessController::class, 'index'])->name('business.settings');
    Route::put('/businesses/{business}', [BusinessController::class, 'update'])->name('business.update');
    Route::get('/billing', [SubscriptionController::class, 'index'])->name('billing.index');
    Route::post('/subscriptions/{plan}/upgrade', [SubscriptionController::class, 'upgrade'])->name('subscriptions.upgrade');
    Route::patch('/subscriptions/{subscription}/cancel', [SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');


    Route::resource('customers', CustomerController::class);
    Route::resource('products', ProductController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('units', UnitController::class);


    Route::get('/sales/search-products', [SaleController::class, 'searchProducts'])->name('sales.search-products');
    Route::get('/sales/search-customers', [SaleController::class, 'searchCustomers'])->name('sales.search-customers');
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('/sales/{sale}', [SaleController::class, 'show'])->name('sales.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


    // Route group for SuperAdmin  only
    Route::group([
        'prefix' => 'sysadmin',
        'as' => 'superadmin.',
        'middleware' => ['auth', 'verified', 'onboarding', 'role:superadmin'],
    ], function () {

        Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('dashboard');
        Route::resource('subscription-plans', SubscriptionPlanController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('users', AdminUserController::class);

    });

require __DIR__ . '/auth.php';
