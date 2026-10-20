<?php

namespace App\Services;

use App\Enums\UniversityStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\University;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UniversityService
{
    public function __construct(
        protected ActivityLogger $logger,
        protected ThemeService $themeService
    ) {}

    /**
     * Buat universitas baru + admin-nya dalam 1 transaksi.
     */
    public function createWithAdmin(array $universityData, array $adminData): University
    {
        return DB::transaction(function () use ($universityData, $adminData) {
            // Validasi warna
            $universityData['primary_color'] = $this->themeService->normalizeHex(
                $universityData['primary_color'] ?? null
            );
            $universityData['secondary_color'] = $this->themeService->normalizeHex(
                $universityData['secondary_color'] ?? null
            );

            $university = University::create($universityData);

            $admin = User::create([
                'university_id' => $university->id,
                'name' => $adminData['name'],
                'email' => $adminData['email'],
                'password' => Hash::make($adminData['password']),
                'role' => UserRole::UNIVERSITY_ADMIN,
                'status' => UserStatus::ACTIVE,
                'email_verified_at' => now(),
            ]);

            $this->logger->log('university.created_with_admin', $university, [
                'admin_id' => $admin->id,
                'admin_email' => $admin->email,
            ]);

            return $university;
        });
    }

    /**
     * Update universitas.
     */
    public function update(University $university, array $data): University
    {
        return DB::transaction(function () use ($university, $data) {
            $before = $university->toArray();

            if (isset($data['primary_color'])) {
                $data['primary_color'] = $this->themeService->normalizeHex($data['primary_color']);
            }
            if (isset($data['secondary_color'])) {
                $data['secondary_color'] = $this->themeService->normalizeHex($data['secondary_color']);
            }

            // Cegah slug diganti dari form (kalau bukan super admin)
            unset($data['slug']);

            $university->update($data);

            $this->logger->updated($university, $before);

            return $university->fresh();
        });
    }

    /**
     * Toggle status universitas (active ↔ inactive).
     */
    public function toggleStatus(University $university): University
    {
        return DB::transaction(function () use ($university) {
            $newStatus = $university->status === UniversityStatus::ACTIVE
                ? UniversityStatus::INACTIVE
                : UniversityStatus::ACTIVE;

            $before = $university->toArray();
            $university->update(['status' => $newStatus]);

            $this->logger->log('university.status_toggled', $university, [
                'before' => $before['status'],
                'after' => $newStatus->value,
            ]);

            return $university->fresh();
        });
    }

    /**
     * Upload logo universitas.
     */
    public function updateLogo(University $university, $file): University
    {
        // Hapus logo lama
        if ($university->logo_path && Storage::disk('public')->exists($university->logo_path)) {
            Storage::disk('public')->delete($university->logo_path);
        }

        $path = $file->store('universities/logos', 'public');
        $university->update(['logo_path' => $path]);

        $this->logger->log('university.logo_updated', $university);

        return $university->fresh();
    }
}