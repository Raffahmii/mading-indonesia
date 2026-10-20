<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ShareUniversityTheme
{
    /**
     * Bagikan $theme ke semua view.
     * Isinya:
     *  - primary
     *  - secondary
     *  - name
     *  - logo_url
     *  - slug
     * Ambil dari user yang login (kalau university_admin).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $theme = (object) [
            'primary' => config('mading.theme.default_primary', '#8E1EA2'),
            'secondary' => config('mading.theme.default_secondary', '#C654C3'),
            'accent' => config('mading.theme.default_accent', '#ED96D7'),
            'soft' => config('mading.theme.default_soft', '#FFC0DE'),
            'name' => config('mading.app_name', 'Mading Indonesia'),
            'logo_url' => asset('images/brand/logo.png'),
            'slug' => null,
        ];

        if ($user && $user->university) {
            $university = $user->university;

            $theme->primary = $university->primary_color;
            $theme->secondary = $university->secondary_color;
            $theme->name = $university->name;
            $theme->logo_url = $university->logo_url;
            $theme->slug = $university->slug;
        }

        View::share('theme', $theme);

        return $next($request);
    }
}