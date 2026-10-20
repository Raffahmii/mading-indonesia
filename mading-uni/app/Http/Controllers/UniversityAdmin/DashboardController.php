<?php

namespace App\Http\Controllers\UniversityAdmin;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Karena UniversityScope aktif, query otomatis terfilter
        $stats = [
            'total' => Post::count(),
            'draft' => Post::where('status', PostStatus::DRAFT)->count(),
            'pending' => Post::where('status', PostStatus::PENDING)->count(),
            'published' => Post::where('status', PostStatus::PUBLISHED)->count(),
            'rejected' => Post::where('status', PostStatus::REJECTED)->count(),
        ];

        $recentPosts = Post::with(['category'])
            ->latest()
            ->limit(5)
            ->get();

        $rejectedPosts = Post::where('status', PostStatus::REJECTED)
            ->with(['category', 'reviews' => function ($q) {
                $q->where('action', 'rejected')->latest();
            }])
            ->latest()
            ->limit(3)
            ->get();

        return view('university-admin.dashboard', compact('stats', 'recentPosts', 'rejectedPosts'));
    }
}