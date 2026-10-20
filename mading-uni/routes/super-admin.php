<?php

use App\Http\Controllers\SuperAdmin\ActivityLogController;
use App\Http\Controllers\SuperAdmin\ApprovalController;
use App\Http\Controllers\SuperAdmin\CategoryController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\MemberController;
use App\Http\Controllers\SuperAdmin\PostController;
use App\Http\Controllers\SuperAdmin\SettingController;
use App\Http\Controllers\SuperAdmin\UniversityAdminController;
use App\Http\Controllers\SuperAdmin\UniversityController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Super Admin Routes
|--------------------------------------------------------------------------
| Prefix: /super-admin
| Middleware: auth, active, role:super_admin
*/

Route::prefix('super-admin')
    ->name('super-admin.')
    ->middleware(['auth', 'active', 'role:super_admin'])
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Universitas
        Route::resource('universities', UniversityController::class);
        Route::post('universities/{university}/toggle-status', [UniversityController::class, 'toggleStatus'])
            ->name('universities.toggle-status');

        // Admin universitas
        Route::resource('admins', UniversityAdminController::class);
        Route::post('admins/{admin}/toggle-status', [UniversityAdminController::class, 'toggleStatus'])
            ->name('admins.toggle-status');

        // Member
        Route::get('members', [MemberController::class, 'index'])->name('members.index');
        Route::get('members/{member}', [MemberController::class, 'show'])->name('members.show');
        Route::post('members/{member}/toggle-status', [MemberController::class, 'toggleStatus'])
            ->name('members.toggle-status');

        // Kategori
        Route::resource('categories', CategoryController::class);

        // Konten (view only + moderasi)
        Route::get('posts', [PostController::class, 'index'])->name('posts.index');
        Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');

        // Approval
        Route::get('approvals', [ApprovalController::class, 'index'])->name('approvals.index');
        Route::get('approvals/{post}', [ApprovalController::class, 'show'])->name('approvals.show');
        Route::post('approvals/{post}/approve', [ApprovalController::class, 'approve'])->name('approvals.approve');
        Route::post('approvals/{post}/reject', [ApprovalController::class, 'reject'])->name('approvals.reject');
        Route::post('approvals/{post}/publish', [ApprovalController::class, 'publish'])->name('approvals.publish');
        Route::post('approvals/{post}/archive', [ApprovalController::class, 'archive'])->name('approvals.archive');

        // Activity log
        Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

        // Settings
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });