<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\UnitController;

use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome');
// });

// Route to display the Privacy Policy page
Route::get('/privacy-policy', function () {
    return view('consent.policy');
})->name('policy');

// Route to display the Terms of Service page
Route::get('/terms-and-conditions', function () {
    return view('consent.terms');
})->name('terms');



// Google login routes
Route::get('auth/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);



Route::get('/', function () {
    return file_get_contents(public_path('landing/index.html'));
})->name('home');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/business/settings', [BusinessController::class, 'index'])->name('business.settings');
    Route::put('/businesses/{business}', [BusinessController::class, 'update'])->name('business.update');


    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');


    // routes/web.php
    Route::resource('customers', CustomerController::class);

    Route::resource('products', ProductController::class);
    Route::resource('suppliers', SupplierController::class);

    Route::resource('units', UnitController::class);











    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
