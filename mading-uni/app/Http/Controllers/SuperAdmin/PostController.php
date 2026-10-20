<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::withoutGlobalScopes()
            ->with(['university', 'category', 'author']);

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($univId = $request->query('university_id')) {
            $query->where('university_id', $univId);
        }

        if ($search = $request->query('q')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $posts = $query->latest()->paginate(20)->withQueryString();
        $universities = \App\Models\University::orderBy('name')->get();

        return view('super-admin.posts.index', compact('posts', 'universities'));
    }

    public function show(Post $post)
    {
        $post->load(['university', 'category', 'author', 'reviews.actor']);

        return view('super-admin.posts.show', compact('post'));
    }
}   