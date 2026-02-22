<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContactController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [HomeController::class, 'about'])->name('about');

    // Maintenance Page
    Route::get('/maintenance', function () {
        return view('frontend.maintenance');
    })->name('maintenance');

    // Services
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

    // Agencies
    Route::get('/agencies', [\App\Http\Controllers\AgencyController::class, 'index'])->name('agencies.index');

    // Activities
    Route::get('/activities', [\App\Http\Controllers\ActivityController::class, 'index'])->name('activities.index');
    Route::get('/activities/{slug}', [\App\Http\Controllers\ActivityController::class, 'show'])->name('activities.show');

    // Gallery
    Route::get('/gallery', [\App\Http\Controllers\GalleryController::class, 'index'])->name('gallery.index');

    // Branches
    Route::get('/branches', [\App\Http\Controllers\BranchController::class, 'index'])->name('branches.index');

    // Products
    Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

    // Search
    Route::get('/search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search');

    // Contact
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

    // Generic Pages (Dynamic)
    Route::get('/p/{slug}', [\App\Http\Controllers\PageController::class, 'show'])->name('pages.show');
});

// Documentation Routes (Protected or Public based on need, making Public for now)
Route::prefix('docs')->name('docs.')->group(function () {
    Route::get('/', [App\Http\Controllers\DocumentationController::class, 'index'])->name('index');
    Route::get('/user-guide', [App\Http\Controllers\DocumentationController::class, 'userGuide'])->name('user-guide');
    Route::get('/developer-guide', [App\Http\Controllers\DocumentationController::class, 'developerGuide'])->name('developer-guide');
});

// Fallback: Laravel's built-in auth/guest middleware looks for a route named 'login'
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');
