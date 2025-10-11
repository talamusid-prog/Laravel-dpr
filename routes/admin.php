<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\AspirationController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AuthController;

Route::prefix('admin')->name('admin.')->group(function () {
    // Authentication
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Redirect to login if not authenticated
    Route::get('/', function () {
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }
        return app(DashboardController::class)->index();
    })->name('dashboard');
    
    // Protected routes
    Route::middleware(['auth'])->group(function () {
        // Articles
        Route::resource('articles', ArticleController::class);
        Route::post('articles/bulk-action', [ArticleController::class, 'bulkAction'])->name('articles.bulk-action');
        Route::post('articles/upload-image', [ArticleController::class, 'uploadImage'])->name('articles.upload-image');
        
        // Override create route to use custom view
        Route::get('articles/create', function () {
            return Inertia::render('Admin/Articles/Create');
        })->name('articles.create');
        
        // Override edit route to use custom view
        Route::get('articles/{article}/edit', function ($article) {
            $article = \App\Models\Article::findOrFail($article);
            return Inertia::render('Admin/Articles/Edit', ['article' => $article]);
        })->name('articles.edit');
    
    // Gallery
    Route::resource('gallery', GalleryController::class);
    Route::post('gallery/bulk-upload', [GalleryController::class, 'bulkUpload'])->name('gallery.bulk-upload');
    
    // Aspirations
    Route::resource('aspirations', AspirationController::class);
    Route::post('aspirations/{aspiration}/respond', [AspirationController::class, 'respond'])->name('aspirations.respond');
    Route::patch('aspirations/{aspiration}/status', [AspirationController::class, 'updateStatus'])->name('aspirations.update-status');
    Route::post('aspirations/export', [AspirationController::class, 'export'])->name('aspirations.export');
    
    // Events
    Route::resource('events', EventController::class);
    Route::get('events/calendar', [EventController::class, 'calendar'])->name('events.calendar');
    
    // Analytics
    Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics');
    Route::get('analytics/export', [AnalyticsController::class, 'export'])->name('analytics.export');
    
        // Settings
        Route::get('settings', [SettingsController::class, 'index'])->name('settings');
        Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::get('settings/colors', function () {
            return Inertia::render('Admin/Settings/Colors');
        })->name('settings.colors');
    });
});
