<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    public function index(Request $request)
    {
        $query = University::active()
            ->withCount(['publishedPosts']);

        // Filter by city
        if ($city = $request->query('city')) {
            $query->where('city', $city);
        }

        // Search by name
        if ($search = $request->query('q')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $universities = $query->orderBy('name')->paginate(12)->withQueryString();

        $cities = University::active()
            ->whereNotNull('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        return view('public.universities.index', compact('universities', 'cities'));
    }

    public function show(University $university)
    {
        abort_if($university->status->value !== 'active', 404);

        $university->load(['publishedPosts' => function ($q) {
            $q->with(['category', 'author'])->orderByDesc('published_at');
        }]);

        $posts = $university->publishedPosts()
            ->with(['category', 'author'])
            ->orderByDesc('published_at')
            ->paginate(9);

        $categories = \App\Models\Category::active()
            ->whereHas('publishedPosts', function ($q) use ($university) {
                $q->where('university_id', $university->id);
            })
            ->withCount(['publishedPosts' => function ($q) use ($university) {
                $q->where('university_id', $university->id);
            }])
            ->orderByDesc('published_posts_count')
            ->get();

        return view('public.universities.show', compact('university', 'posts', 'categories'));
    }
}