<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', UserRole::MEMBER);

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $members = $query->orderBy('name')->paginate(20)->withQueryString();

        return view('super-admin.members.index', compact('members'));
    }

    public function show(User $member)
    {
        abort_if($member->role !== UserRole::MEMBER, 404);
        $member->loadCount('bookmarks');

        return view('super-admin.members.show', compact('member'));
    }

    public function toggleStatus(User $member)
    {
        abort_if($member->role !== UserRole::MEMBER, 404);

        $newStatus = $member->status === UserStatus::ACTIVE
            ? UserStatus::SUSPENDED
            : UserStatus::ACTIVE;

        $member->update(['status' => $newStatus]);

        return back()->with('success', 'Status member berhasil diubah.');
    }
}