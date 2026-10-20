<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;

class UserPolicy
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
        return false; // hanya super_admin
    }

    public function view(User $user, User $target): bool
    {
        // User bisa lihat dirinya sendiri
        if ($user->id === $target->id) {
            return true;
        }

        return false;
    }

    public function update(User $user, User $target): bool
    {
        // User bisa update dirinya sendiri
        if ($user->id === $target->id) {
            return true;
        }

        return false;
    }

    public function delete(User $user, User $target): bool
    {
        return false;
    }
}