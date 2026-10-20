<?php

use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\UniversityController;
use App\Http\Controllers\Public\PostController;
use App\Http\Controllers\Public\SearchController;
use App\Http\Controllers\Public\CategoryController;
use App\Http\Controllers\Public\BookmarkController;
use App\Http\Controllers\Member\DashboardController;
use App\Http\Controllers\Member\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::name('public.')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/universitas', [UniversityController::class, 'index'])->name('universities.index');
    Route::get('/universitas/{university:slug}', [UniversityController::class, 'show'])->name('universities.show');
    Route::get('/universitas/{university:slug}/{post:slug}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/kategori/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

    // Bookmark (butuh login)
    Route::middleware(['auth', 'active'])->group(function () {
        Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
        Route::post('/posts/{post}/bookmark', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
    });
});


/*
|--------------------------------------------------------------------------
| Member Routes (khusus member)
|--------------------------------------------------------------------------
| Prefix: /member
| Middleware: auth, active, role:member
*/

Route::prefix('member')
    ->name('member.')
    ->middleware(['auth', 'active', 'role:member'])
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks');

        // Profil
        Route::get('/profil', [ProfileController::class, 'edit'])->name('profile');
        Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');

        // Password
        Route::get('/password', [ProfileController::class, 'showPassword'])->name('password');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });