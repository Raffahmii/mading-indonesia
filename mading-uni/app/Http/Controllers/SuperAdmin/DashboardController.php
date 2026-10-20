<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\PostStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\University;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'universities' => University::count(),
            'admins' => User::where('role', UserRole::UNIVERSITY_ADMIN)->count(),
            'members' => User::where('role', UserRole::MEMBER)->count(),
            'posts_total' => Post::withoutGlobalScopes()->count(),
            'posts_pending' => Post::withoutGlobalScopes()->where('status', PostStatus::PENDING)->count(),
            'posts_published' => Post::withoutGlobalScopes()->where('status', PostStatus::PUBLISHED)->count(),
            'posts_draft' => Post::withoutGlobalScopes()->where('status', PostStatus::DRAFT)->count(),
            'categories' => Category::count(),
        ];

        $pendingPosts = Post::withoutGlobalScopes()
            ->where('status', PostStatus::PENDING)
            ->with(['university', 'category', 'author'])
            ->orderBy('submitted_at')
            ->limit(5)
            ->get();

        $recentPosts = Post::withoutGlobalScopes()
            ->with(['university', 'category'])
            ->latest()
            ->limit(5)
            ->get();

        return view('super-admin.dashboard', compact('stats', 'pendingPosts', 'recentPosts'));
    }
}