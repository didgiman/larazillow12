<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\UserAccountController;
use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome');
// })->name('home');

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/hello', [IndexController::class, 'show'])
    ->middleware('auth')
    ->name('show');

Route::resource('listings', ListingController::class)
    ->only(['index', 'show']);



Route::get('course/login', [AuthController::class, 'create'])->name('course-login');
// ->name('course-login');
Route::post('course/login', [AuthController::class, 'store'])->name('course-login-store');
Route::delete('course/logout', [AuthController::class, 'destroy'])->name('course-logout');

Route::resource('user-account', UserAccountController::class)
    ->only('create', 'store');

Route::prefix('realtor')
    ->name('realtor.')
    ->middleware('auth')
    ->group(function() {
        Route::put('listings/{listing}/restore', [RealtorListingController::class, 'restore'])->name('listing.restore')->withTrashed();

        Route::resource('listings', RealtorListingController::class)
            ->only(['index', 'destroy', 'create', 'store', 'edit', 'update'])
            ->withTrashed();
    });

Route::prefix('dashboard')
    ->middleware(['auth', 'verified'])
    ->group(function() {

        Route::get('/', function() {
            return Inertia::render('Dashboard');
        })->name('dashboard');

        Route::get('listings', function() {
            $listings = Auth::user()->listings;
            return Inertia::render('Dashboard/Listings/Index', ['listings' => $listings]);
        })->name('dashboard.listings');

        Route::get('listings/{listing}/edit', function(Listing $listing) {
             return Inertia::render('Dashboard/Listings/Edit', ['listing' => $listing]);
        })->name('dashboard.listings.edit');

    });

// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
