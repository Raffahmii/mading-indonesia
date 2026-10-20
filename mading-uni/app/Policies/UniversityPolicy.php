<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\University;
use App\Models\User;

class UniversityPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->role === UserRole::SUPER_ADMIN) {
            return true;
        }

        return null;
    }

    /**
     * Hanya super admin yang bisa CRUD universitas.
     * Untuk university_admin, mereka cuma bisa update profil universitasnya.
     */

    public function viewAny(User $user): bool
    {
        return false; // super_admin di-override by before()
    }

    public function view(User $user, University $university): bool
    {
        if ($user->role === UserRole::UNIVERSITY_ADMIN) {
            return $user->university_id === $university->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, University $university): bool
    {
        // University admin bisa edit profil univ sendiri
        if ($user->role === UserRole::UNIVERSITY_ADMIN) {
            return $user->university_id === $university->id;
        }

        return false;
    }

    public function delete(User $user, University $university): bool
    {
        return false; // hanya super_admin
    }
}