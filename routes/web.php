<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('profil', function () {
    return Inertia::render('Profile');
})->name('profile');

Route::get('kalender', function () {
    return Inertia::render('Kalender');
})->name('kalender');

Route::get('blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog');
Route::get('blog/{slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.detail');

Route::get('aspirasi', function () {
    return Inertia::render('Aspirasi');
})->name('aspirasi');

Route::get('pendaftaran-anggota', function () {
    return Inertia::render('MemberRegistration');
})->name('member.registration');

Route::post('aspirasi', [App\Http\Controllers\AspirationController::class, 'store'])->name('aspirasi.store');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
