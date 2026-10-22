<?php

namespace App\Http\Controllers\UniversityAdmin;

use App\Http\Controllers\Controller;
use App\Services\UniversityService;
use Illuminate\Http\Request;

class UniversityProfileController extends Controller
{
    public function __construct(
        protected UniversityService $universityService
    ) {}

    public function edit()
    {
        $university = auth()->user()->university;
        abort_if(! $university, 404);

        return view('university-admin.profile.edit', compact('university'));
    }

    public function update(Request $request)
    {
        $university = auth()->user()->university;
        abort_if(! $university, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'primary_color' => ['required', 'string', 'regex:/^#?[0-9A-Fa-f]{6}$/'],
            'secondary_color' => ['required', 'string', 'regex:/^#?[0-9A-Fa-f]{6}$/'],
            'city' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $this->universityService->updateLogo($university, $request->file('logo'));
        }

        // Update data (kecuali file)
        unset($validated['logo']);
        
        $this->universityService->update($university, $validated);

        return back()->with('success', 'Profil universitas berhasil diperbarui.');
    }
}