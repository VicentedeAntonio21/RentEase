<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PropertyController as AdminPropertyController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Owner\ReportController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ChatController;

Route::get('/', [WelcomeController::class, 'index'])->name('home');
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
Route::get('/listings/{unit}', [ListingController::class, 'show'])->name('listings.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/chat', [ChatController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('chat.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/units/{unit}/apply', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/units/{unit}/apply', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/my-applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::patch('/applications/{application}/cancel', [ApplicationController::class, 'cancel'])->name('applications.cancel');
});

Route::middleware(['auth', 'verified', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::resource('properties', PropertyController::class);
    Route::resource('properties.units', UnitController::class)->shallow();
    Route::get('/applications', [ApplicationController::class, 'received'])->name('applications.received');
    Route::patch('/applications/{application}/approve', [ApplicationController::class, 'approve'])->name('applications.approve');
    Route::patch('/applications/{application}/reject', [ApplicationController::class, 'reject'])->name('applications.reject');
    Route::resource('properties', PropertyController::class);
    Route::resource('properties.units', UnitController::class)->shallow();
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
});

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::get('/properties', [AdminPropertyController::class, 'index'])->name('properties.index');
    Route::delete('/properties/{property}', [AdminPropertyController::class, 'destroy'])->name('properties.destroy');
    Route::get('/applications', [AdminApplicationController::class, 'index'])->name('applications.index');
});

require __DIR__.'/auth.php';
