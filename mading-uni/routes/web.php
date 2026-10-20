<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Orkestrator
|--------------------------------------------------------------------------
| File ini cuma include file route lain. Logic route ada di masing-masing file.
*/

// Auth (dari Breeze)
require __DIR__.'/auth.php';

// Public (guest & member)
require __DIR__.'/public.php';

// Super Admin (/super-admin/*)
require __DIR__.'/super-admin.php';

// University Admin (/admin/*)
require __DIR__.'/university-admin.php';


/*
|--------------------------------------------------------------------------
| Authenticated User Redirect
|--------------------------------------------------------------------------
| Setelah login, arahkan user ke dashboard sesuai role-nya.
*/

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match ($user->role->value) {
            'super_admin'      => redirect()->route('super-admin.dashboard'),
            'university_admin' => redirect()->route('university-admin.dashboard'),
            default            => redirect()->route('public.home'),
        };
    })->name('dashboard');
});
