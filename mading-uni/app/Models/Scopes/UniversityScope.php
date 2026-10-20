<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class UniversityScope implements Scope
{
    /**
     * Terapkan scope ke query.
     * Scope hanya aktif kalau:
     * - User login
     * - Role = university_admin
     * - User punya university_id
     */
    public function apply(Builder $builder, Model $model): void
    {
        $user = auth()->user();

        // Skip kalau:
        // - nggak ada user login (CLI, seeder, guest)
        // - user bukan university_admin (super_admin bisa lihat semua)
        // - user nggak punya university_id
        if (! $user) {
            return;
        }

        if ($user->role !== \App\Enums\UserRole::UNIVERSITY_ADMIN) {
            return;
        }

        if (empty($user->university_id)) {
            return;
        }

        $builder->where(
            $model->getTable() . '.university_id',
            $user->university_id
        );
    }
}