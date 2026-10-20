<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\PostWorkflowService;
use Illuminate\Http\Request;
use InvalidArgumentException;

class ApprovalController extends Controller
{
    public function __construct(
        protected PostWorkflowService $workflow
    ) {}

    public function index(Request $request)
    {
        $query = Post::withoutGlobalScopes()
            ->where('status', PostStatus::PENDING)
            ->with(['university', 'category', 'author']);

        $posts = $query->orderBy('submitted_at')->paginate(15);

        return view('super-admin.approvals.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $post->load(['university', 'category', 'author', 'reviews.actor']);

        return view('super-admin.approvals.show', compact('post'));
    }

    public function approve(Request $request, Post $post)
    {
        $request->validate([
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        try {
            $this->workflow->approve($post, $request->user(), $request->input('note'));

            return redirect()
                ->route('super-admin.approvals.index')
                ->with('success', 'Konten berhasil disetujui.');
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function reject(Request $request, Post $post)
    {
        $validated = $request->validate([
            'note' => ['required', 'string', 'max:1000'],
        ]);

        try {
            $this->workflow->reject($post, $request->user(), $validated['note']);

            return redirect()
                ->route('super-admin.approvals.index')
                ->with('success', 'Konten ditolak.');
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function publish(Request $request, Post $post)
    {
        try {
            $this->workflow->publish($post, $request->user(), $request->input('note'));

            return redirect()
                ->route('super-admin.approvals.index')
                ->with('success', 'Konten berhasil dipublikasikan.');
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function archive(Request $request, Post $post)
    {
        try {
            $this->workflow->archive($post, $request->user(), $request->input('note'));

            return redirect()
                ->route('super-admin.approvals.index')
                ->with('success', 'Konten diarsipkan.');
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}