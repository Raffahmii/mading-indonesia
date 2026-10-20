<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Stats
        $stats = [
            'bookmarks' => $user->bookmarks()->count(),
        ];

        // Bookmark terbaru
        $recentBookmarks = $user->bookmarks()
            ->with(['post.university', 'post.category'])
            ->latest('created_at')
            ->limit(6)
            ->get()
            ->pluck('post')
            ->filter();

        // Konten terbaru dari universitas yang user bookmark
        $universityIds = $user->bookmarks()
            ->with('post')
            ->get()
            ->pluck('post.university_id')
            ->filter()
            ->unique()
            ->toArray();

        $suggestedPosts = Post::published()
            ->whereIn('university_id', $universityIds)
            ->with(['university', 'category'])
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('member.dashboard', compact('stats', 'recentBookmarks', 'suggestedPosts'));
    }
}