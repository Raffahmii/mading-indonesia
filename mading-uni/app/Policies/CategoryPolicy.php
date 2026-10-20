<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->role === UserRole::SUPER_ADMIN) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        // Semua role login bisa lihat list (buat dropdown pilih kategori)
        return true;
    }

    public function view(User $user, Category $category): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false; // hanya super_admin
    }

    public function update(User $user, Category $category): bool
    {
        return false;
    }

    public function delete(User $user, Category $category): bool
    {
        return false;
    }
}