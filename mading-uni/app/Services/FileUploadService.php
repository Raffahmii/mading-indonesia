<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

class FileUploadService
{
    /**
     * Upload file umum.
     */
    public function upload(UploadedFile $file, string $directory, string $disk = 'public'): string
    {
        $this->validateFile($file);

        return $file->store($directory, $disk);
    }

    /**
     * Upload dengan nama kustom.
     */
    public function uploadAs(UploadedFile $file, string $directory, string $filename, string $disk = 'public'): string
    {
        $this->validateFile($file);

        return $file->storeAs($directory, $filename, $disk);
    }

    /**
     * Hapus file.
     */
    public function delete(?string $path, string $disk = 'public'): bool
    {
        if (empty($path)) {
            return false;
        }

        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }

    /**
     * Ganti file (hapus lama, upload baru).
     */
    public function replace(?string $oldPath, UploadedFile $newFile, string $directory, string $disk = 'public'): string
    {
        $this->delete($oldPath, $disk);

        return $this->upload($newFile, $directory, $disk);
    }

    /**
     * Validasi file.
     */
    protected function validateFile(UploadedFile $file): void
    {
        if (! $file->isValid()) {
            throw new InvalidArgumentException('File tidak valid atau gagal diupload.');
        }

        $maxKb = config('mading.upload.logo_max_kb', 2048);
        if ($file->getSize() > $maxKb * 1024) {
            throw new InvalidArgumentException("Ukuran file maksimal {$maxKb} KB.");
        }

        $mimes = config('mading.upload.image_mimes', ['jpg', 'jpeg', 'png', 'webp', 'svg']);
        $ext = strtolower($file->getClientOriginalExtension());

        if (! in_array($ext, $mimes, true)) {
            throw new InvalidArgumentException('Tipe file tidak diizinkan. Hanya: ' . implode(', ', $mimes));
        }
    }
}