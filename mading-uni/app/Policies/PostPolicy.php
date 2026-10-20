<?php

namespace App\Policies;

use App\Enums\PostStatus;
use App\Enums\UserRole;
use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Super admin bisa semua.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->role === UserRole::SUPER_ADMIN) {
            return true;
        }

        return null;
    }

    /**
     * Lihat daftar post.
     * - university_admin: hanya universitasnya
     * - member & guest: tidak boleh (public pakai route lain)
     */
    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::UNIVERSITY_ADMIN;
    }

    /**
     * Lihat detail post.
     */
    public function view(User $user, Post $post): bool
    {
        if ($user->role === UserRole::UNIVERSITY_ADMIN) {
            return $user->university_id === $post->university_id;
        }

        return false;
    }

    /**
     * Buat post baru.
     */
    public function create(User $user): bool
    {
        return $user->role === UserRole::UNIVERSITY_ADMIN
            && $user->university_id !== null;
    }

    /**
     * Update post.
     * Admin hanya bisa edit post universitasnya & status editable.
     */
    public function update(User $user, Post $post): bool
    {
        if ($user->role !== UserRole::UNIVERSITY_ADMIN) {
            return false;
        }

        if ($user->university_id !== $post->university_id) {
            return false;
        }

        return $post->status->isEditable();
    }

    /**
     * Hapus post.
     */
    public function delete(User $user, Post $post): bool
    {
        if ($user->role !== UserRole::UNIVERSITY_ADMIN) {
            return false;
        }

        return $user->university_id === $post->university_id;
    }

    /**
     * Submit untuk approval.
     */
    public function submit(User $user, Post $post): bool
    {
        if ($user->role !== UserRole::UNIVERSITY_ADMIN) {
            return false;
        }

        if ($user->university_id !== $post->university_id) {
            return false;
        }

        return $post->status->canBeSubmitted();
    }

    /**
     * Approve / reject.
     * Hanya super admin (ditangani di before()).
     */
    public function review(User $user, Post $post): bool
    {
        return false; // akan di-override oleh before() untuk super_admin
    }

    /**
     * Publish.
     * Hanya super admin.
     */
    public function publish(User $user, Post $post): bool
    {
        return false; // akan di-override oleh before() untuk super_admin
    }
}