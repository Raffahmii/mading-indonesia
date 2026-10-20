<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Services\UniversityService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UniversityController extends Controller
{
    public function __construct(
        protected UniversityService $universityService
    ) {}

    public function index(Request $request)
    {
        $query = University::query()->withCount(['posts', 'admins']);

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $universities = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('super-admin.universities.index', compact('universities'));
    }

    public function create()
    {
        return view('super-admin.universities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150', 'unique:universities,name'],
            'primary_color' => ['required', 'string', 'regex:/^#?[0-9A-Fa-f]{6}$/'],
            'secondary_color' => ['required', 'string', 'regex:/^#?[0-9A-Fa-f]{6}$/'],
            'city' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'description' => ['nullable', 'string'],

            // Admin data
            'admin_name' => ['required', 'string', 'max:150'],
            'admin_email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'admin_password' => ['required', 'string', 'min:8'],
        ]);

        $universityData = collect($validated)->only([
            'name', 'primary_color', 'secondary_color', 'city', 'address',
            'website', 'email', 'phone', 'description',
        ])->toArray();

        $adminData = [
            'name' => $validated['admin_name'],
            'email' => $validated['admin_email'],
            'password' => $validated['admin_password'],
        ];

        $university = $this->universityService->createWithAdmin($universityData, $adminData);

        return redirect()
            ->route('super-admin.universities.show', $university)
            ->with('success', "Universitas {$university->name} berhasil dibuat.");
    }

    public function show(University $university)
    {
        $university->loadCount(['posts', 'admins']);
        $university->load(['admins']);

        $recentPosts = $university->posts()
            ->with(['category', 'author'])
            ->latest()
            ->limit(10)
            ->get();

        return view('super-admin.universities.show', compact('university', 'recentPosts'));
    }

    public function edit(University $university)
    {
        return view('super-admin.universities.edit', compact('university'));
    }

    public function update(Request $request, University $university)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150', Rule::unique('universities', 'name')->ignore($university->id)],
            'primary_color' => ['required', 'string', 'regex:/^#?[0-9A-Fa-f]{6}$/'],
            'secondary_color' => ['required', 'string', 'regex:/^#?[0-9A-Fa-f]{6}$/'],
            'city' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'description' => ['nullable', 'string'],
        ]);

        $this->universityService->update($university, $validated);

        return redirect()
            ->route('super-admin.universities.show', $university)
            ->with('success', 'Universitas berhasil diperbarui.');
    }

    public function destroy(University $university)
    {
        if ($university->posts()->exists()) {
            return back()->withErrors(['error' => 'Tidak bisa hapus universitas yang masih punya konten. Arsipkan dulu.']);
        }

        $university->delete();

        return redirect()
            ->route('super-admin.universities.index')
            ->with('success', 'Universitas berhasil dihapus.');
    }

    public function toggleStatus(University $university)
    {
        $this->universityService->toggleStatus($university);

        return back()->with('success', 'Status universitas berhasil diubah.');
    }
}