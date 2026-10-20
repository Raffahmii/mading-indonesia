<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\University;

class PostController extends Controller
{
    public function show(University $university, Post $post)
    {
        // Pastikan post beneran milik universitas ini & published
        abort_if($post->university_id !== $university->id, 404);
        abort_if(! $post->isPublished(), 404);

        $post->load(['category', 'author', 'university']);

        // Increment view count (biar nggak increment kalau refresh, bisa pakai session/cache nanti)
        $post->incrementViewCount();

        // Related posts
        $relatedPosts = Post::published()
            ->where('university_id', $university->id)
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->with(['category', 'author'])
            ->limit(3)
            ->get();

        return view('public.posts.show', compact('post', 'university', 'relatedPosts'));
    }
}