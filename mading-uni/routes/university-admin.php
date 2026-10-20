<?php

use App\Http\Controllers\UniversityAdmin\AccountController;
use App\Http\Controllers\UniversityAdmin\DashboardController;
use App\Http\Controllers\UniversityAdmin\PostController;
use App\Http\Controllers\UniversityAdmin\UniversityProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| University Admin Routes
|--------------------------------------------------------------------------
| Prefix: /admin
| Middleware: auth, active, university.active, role:university_admin
*/

Route::prefix('admin')
    ->name('university-admin.')
    ->middleware(['auth', 'active', 'university.active', 'role:university_admin'])
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Konten
        Route::resource('posts', PostController::class);
        Route::post('posts/{post}/submit', [PostController::class, 'submit'])
            ->name('posts.submit');

        // Profil universitas
        Route::get('profile', [UniversityProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [UniversityProfileController::class, 'update'])->name('profile.update');

        // Akun admin
        Route::get('account', [AccountController::class, 'edit'])->name('account.edit');
        Route::put('account', [AccountController::class, 'update'])->name('account.update');
        Route::put('account/password', [AccountController::class, 'updatePassword'])->name('account.password');
    });