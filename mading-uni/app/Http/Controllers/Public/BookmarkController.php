<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function index(Request $request)
    {
        $bookmarks = $request->user()
            ->bookmarks()
            ->with(['post.university', 'post.category'])
            ->latest('created_at')
            ->paginate(9);

        // Kalau akses dari /member/bookmarks pakai layout member
        // Kalau dari /bookmarks pakai layout public
        $view = request()->routeIs('member.*')
            ? 'member.bookmarks'
            : 'public.bookmarks';

        return view($view, compact('bookmarks'));
    }

    public function toggle(Request $request, Post $post)
    {
        $user = $request->user();

        $existing = $user->bookmarks()->where('post_id', $post->id)->first();

        if ($existing) {
            $existing->delete();
            $bookmarked = false;
            $message = 'Dihapus dari favorit.';
        } else {
            $user->bookmarks()->create(['post_id' => $post->id]);
            $bookmarked = true;
            $message = 'Ditambahkan ke favorit.';
        }

        if ($request->wantsJson()) {
            return response()->json([
                'bookmarked' => $bookmarked,
                'count' => $post->bookmarks()->count(),
            ]);
        }

        return back()->with('success', $message);
    }
}