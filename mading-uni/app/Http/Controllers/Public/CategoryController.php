<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        abort_if(! $category->is_active, 404);

        $posts = Post::published()
            ->where('category_id', $category->id)
            ->with(['university', 'author'])
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('public.categories.show', compact('category', 'posts'));
    }
}