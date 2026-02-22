<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SettingController;

// Auth Routes (Guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// Protected Admin Routes
Route::middleware(['admin'])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pages Management
    Route::resource('pages', PageController::class);

    // Services Management
    Route::resource('services', ServiceController::class);

    // Sliders Management
    Route::resource('sliders', SliderController::class);

    // Users and Roles Management
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);

    // Other Content Management
    Route::resource('agencies', \App\Http\Controllers\Admin\AgencyController::class);
    Route::resource('activities', \App\Http\Controllers\Admin\ActivityController::class);
    // Custom gallery routes MUST come before the resource to avoid {gallery} wildcard conflict
    Route::get('/gallery/bulk-upload', [\App\Http\Controllers\Admin\GalleryImageController::class, 'bulkUpload'])->name('gallery.bulk-upload');
    Route::post('/gallery/upload-multiple', [\App\Http\Controllers\Admin\GalleryImageController::class, 'uploadMultiple'])->name('gallery.upload-multiple');
    Route::resource('gallery', \App\Http\Controllers\Admin\GalleryImageController::class);
    Route::resource('branches', \App\Http\Controllers\Admin\BranchController::class);
    Route::resource('counters', \App\Http\Controllers\Admin\CounterController::class);
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);

    // Reports
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});
