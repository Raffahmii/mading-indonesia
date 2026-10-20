<?php

namespace App\Services;

class ThemeService
{
    /**
     * Normalisasi hex color.
     * - Pastikan diawali #
     * - Huruf besar
     * - Format #RRGGBB
     * Kalau nggak valid, return default.
     */
    public function normalizeHex(?string $hex, ?string $default = null): string
    {
        $default ??= config('mading.theme.default_primary', '#8E1EA2');

        if (empty($hex)) {
            return $default;
        }

        $hex = strtoupper(trim($hex));

        // Tambah # kalau belum ada
        if (! str_starts_with($hex, '#')) {
            $hex = '#' . $hex;
        }

        // Validasi format #RRGGBB
        if (! preg_match('/^#[0-9A-F]{6}$/', $hex)) {
            return $default;
        }

        return $hex;
    }

    /**
     * Validasi hex color.
     */
    public function isValidHex(?string $hex): bool
    {
        if (empty($hex)) {
            return false;
        }

        $hex = strtoupper(trim($hex));
        if (! str_starts_with($hex, '#')) {
            $hex = '#' . $hex;
        }

        return (bool) preg_match('/^#[0-9A-F]{6}$/', $hex);
    }

    /**
     * Turunin shade warna (lebih terang atau lebih gelap).
     *
     * @param  string  $hex  Format #RRGGBB
     * @param  float  $percent  -1.0 (gelap banget) sampai 1.0 (terang banget)
     */
    public function shade(string $hex, float $percent): string
    {
        $hex = ltrim($this->normalizeHex($hex), '#');

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        if ($percent > 0) {
            // Ke arah putih
            $r = (int) ($r + (255 - $r) * $percent);
            $g = (int) ($g + (255 - $g) * $percent);
            $b = (int) ($b + (255 - $b) * $percent);
        } else {
            // Ke arah hitam
            $r = (int) ($r * (1 + $percent));
            $g = (int) ($g * (1 + $percent));
            $b = (int) ($b * (1 + $percent));
        }

        $r = max(0, min(255, $r));
        $g = max(0, min(255, $g));
        $b = max(0, min(255, $b));

        return sprintf('#%02X%02X%02X', $r, $g, $b);
    }

    /**
     * Generate palet turunan dari warna utama.
     * Berguna buat hover, active, background, dll.
     */
    public function generatePalette(string $primary, string $secondary): array
    {
        $primary = $this->normalizeHex($primary);
        $secondary = $this->normalizeHex($secondary);

        return [
            'primary' => $primary,
            'primary_light' => $this->shade($primary, 0.3),
            'primary_lighter' => $this->shade($primary, 0.6),
            'primary_dark' => $this->shade($primary, -0.2),
            'secondary' => $secondary,
            'secondary_light' => $this->shade($secondary, 0.3),
            'secondary_lighter' => $this->shade($secondary, 0.6),
            'secondary_dark' => $this->shade($secondary, -0.2),
        ];
    }
}