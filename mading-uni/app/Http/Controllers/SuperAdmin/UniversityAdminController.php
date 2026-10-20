<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UniversityAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', UserRole::UNIVERSITY_ADMIN)
            ->with('university');

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($univId = $request->query('university_id')) {
            $query->where('university_id', $univId);
        }

        $admins = $query->orderBy('name')->paginate(15)->withQueryString();
        $universities = University::orderBy('name')->get();

        return view('super-admin.admins.index', compact('admins', 'universities'));
    }

    public function create()
    {
        $universities = University::orderBy('name')->get();
        return view('super-admin.admins.create', compact('universities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'university_id' => ['required', 'exists:universities,id'],
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $validated['role'] = UserRole::UNIVERSITY_ADMIN;
        $validated['status'] = UserStatus::ACTIVE;
        $validated['email_verified_at'] = now();
        $validated['password'] = Hash::make($validated['password']);

        $admin = User::create($validated);

        return redirect()
            ->route('super-admin.admins.show', $admin)
            ->with('success', "Admin {$admin->name} berhasil dibuat.");
    }

    public function show(User $admin)
    {
        abort_if($admin->role !== UserRole::UNIVERSITY_ADMIN, 404);
        $admin->load('university');

        return view('super-admin.admins.show', compact('admin'));
    }

    public function edit(User $admin)
    {
        abort_if($admin->role !== UserRole::UNIVERSITY_ADMIN, 404);
        $universities = University::orderBy('name')->get();

        return view('super-admin.admins.edit', compact('admin', 'universities'));
    }

    public function update(Request $request, User $admin)
    {
        abort_if($admin->role !== UserRole::UNIVERSITY_ADMIN, 404);

        $validated = $request->validate([
            'university_id' => ['required', 'exists:universities,id'],
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($admin->id)],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin->update($validated);

        return redirect()
            ->route('super-admin.admins.show', $admin)
            ->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy(User $admin)
    {
        abort_if($admin->role !== UserRole::UNIVERSITY_ADMIN, 404);
        abort_if($admin->id === auth()->id(), 403, 'Tidak bisa hapus diri sendiri.');

        $admin->delete();

        return redirect()
            ->route('super-admin.admins.index')
            ->with('success', 'Admin berhasil dihapus.');
    }

    public function toggleStatus(User $admin)
    {
        abort_if($admin->role !== UserRole::UNIVERSITY_ADMIN, 404);

        $newStatus = $admin->status === UserStatus::ACTIVE
            ? UserStatus::SUSPENDED
            : UserStatus::ACTIVE;

        $admin->update(['status' => $newStatus]);

        return back()->with('success', 'Status admin berhasil diubah.');
    }
}