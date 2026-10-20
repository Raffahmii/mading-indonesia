<?php

namespace App\Http\Controllers\UniversityAdmin;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Services\FileUploadService;
use App\Services\PostWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use InvalidArgumentException;

class PostController extends Controller
{
    public function __construct(
        protected PostWorkflowService $workflow,
        protected FileUploadService $uploads
    ) {}

    public function index(Request $request)
    {
        $query = Post::with(['category']);

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->query('q')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $posts = $query->latest()->paginate(15)->withQueryString();

        // Hitung statistik
        $stats = [
            'all' => Post::count(),
            'draft' => Post::where('status', PostStatus::DRAFT)->count(),
            'pending' => Post::where('status', PostStatus::PENDING)->count(),
            'published' => Post::where('status', PostStatus::PUBLISHED)->count(),
            'rejected' => Post::where('status', PostStatus::REJECTED)->count(),
        ];

        return view('university-admin.posts.index', compact('posts', 'stats'));
    }

    public function create()
    {
        $categories = Category::active()->orderBy('name')->get();

        return view('university-admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'cover' => ['nullable', 'image', 'max:4096'],
            'event_start' => ['nullable', 'date'],
            'event_end' => ['nullable', 'date', 'after_or_equal:event_start'],
            'location' => ['nullable', 'string', 'max:200'],
        ]);

        if ($request->hasFile('cover')) {
            $validated['cover_image_path'] = $this->uploads->upload(
                $request->file('cover'),
                config('mading.upload.cover_path', 'posts/covers')
            );
        }

        $validated['author_id'] = auth()->id();
        $validated['status'] = PostStatus::DRAFT;

        // university_id auto dari scope
        $post = Post::create($validated);

        return redirect()
            ->route('university-admin.posts.show', $post)
            ->with('success', 'Konten berhasil dibuat. Silakan submit untuk review.');
    }

    public function show(Post $post)
    {
        $this->authorize('view', $post);

        $post->load(['category', 'reviews.actor']);

        return view('university-admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $categories = Category::active()->orderBy('name')->get();

        return view('university-admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'cover' => ['nullable', 'image', 'max:4096'],
            'event_start' => ['nullable', 'date'],
            'event_end' => ['nullable', 'date', 'after_or_equal:event_start'],
            'location' => ['nullable', 'string', 'max:200'],
        ]);

        if ($request->hasFile('cover')) {
            $validated['cover_image_path'] = $this->uploads->replace(
                $post->cover_image_path,
                $request->file('cover'),
                config('mading.upload.cover_path', 'posts/covers')
            );
        }

        $post->update($validated);

        return redirect()
            ->route('university-admin.posts.show', $post)
            ->with('success', 'Konten berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->cover_image_path) {
            $this->uploads->delete($post->cover_image_path);
        }

        $post->delete();

        return redirect()
            ->route('university-admin.posts.index')
            ->with('success', 'Konten berhasil dihapus.');
    }

    public function submit(Post $post)
    {
        $this->authorize('submit', $post);

        try {
            $this->workflow->submit($post, auth()->user());

            return back()->with('success', 'Konten berhasil diajukan untuk review.');
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}