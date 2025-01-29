<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\UserManagement;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\UserProfile;

// Main Page Route dengan middleware auth
Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomePage::class, 'index'])->name('pages-home');
    Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');

    //UserManagement
    Route::get('/user-profile', [UserProfile::class, 'userProfile'])->name('content.user.User-profile');
    Route::get('/user-management', [UserManagement::class, 'UserManagement'])->name('content.user.User-management');
    Route::get('/user-list', [UserManagement::class, 'index'])->name('user-list');
    Route::get('/user-edit/{id}', [UserManagement::class, 'edit'])->name('user-edit');
    Route::delete('/user-delete/{id}', [UserManagement::class, 'destroy'])->name('user-delete');
});

// locale
Route::get('/lang/{locale}', [LanguageController::class, 'swap']);

// Halaman error
Route::get('/error', [MiscError::class, 'index'])->name('content.error.error');

Route::fallback(function () {
  return redirect()->route('content.error.error');
});
