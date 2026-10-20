<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\University;

class HomeController extends Controller
{
    public function index()
    {
        $featuredUniversities = University::active()
            ->withCount(['publishedPosts'])
            ->orderByDesc('published_posts_count')
            ->limit(6)
            ->get();

        $latestPosts = Post::published()
            ->with(['university', 'category', 'author'])
            ->orderByDesc('published_at')
            ->limit(9)
            ->get();

        $upcomingEvents = Post::published()
            ->upcoming()
            ->with(['university', 'category'])
            ->limit(4)
            ->get();

        $categories = Category::active()
            ->withCount(['publishedPosts'])
            ->orderByDesc('published_posts_count')
            ->limit(6)
            ->get();

        return view('public.home', compact(
            'featuredUniversities',
            'latestPosts',
            'upcomingEvents',
            'categories'
        ));
    }
}