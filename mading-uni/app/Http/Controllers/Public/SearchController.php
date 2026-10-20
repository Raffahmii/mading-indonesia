<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\University;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $type = $request->query('type', 'all');

        $universities = collect();
        $posts = collect();

        if ($q !== '') {
            if (in_array($type, ['all', 'university'])) {
                $universities = University::active()
                    ->where(function ($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%")
                            ->orWhere('city', 'like', "%{$q}%")
                            ->orWhere('description', 'like', "%{$q}%");
                    })
                    ->limit(10)
                    ->get();
            }

            if (in_array($type, ['all', 'post'])) {
                $posts = Post::published()
                    ->with(['university', 'category'])
                    ->where(function ($query) use ($q) {
                        $query->where('title', 'like', "%{$q}%")
                            ->orWhere('excerpt', 'like', "%{$q}%")
                            ->orWhere('body', 'like', "%{$q}%");
                    })
                    ->orderByDesc('published_at')
                    ->paginate(12);
            }
        }

        return view('public.search', compact('q', 'type', 'universities', 'posts'));
    }
}