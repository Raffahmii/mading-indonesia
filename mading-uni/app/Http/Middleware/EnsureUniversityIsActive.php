<?php

namespace App\Http\Middleware;

use App\Enums\UniversityStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUniversityIsActive
{
    /**
     * Tolak admin dari universitas inactive.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->university_id) {
            $university = $user->university;

            if ($university && $university->status !== UniversityStatus::ACTIVE) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()
                    ->route('login')
                    ->withErrors(['email' => 'Universitas kamu sedang nonaktif. Hubungi Super Admin.']);
            }
        }

        return $next($request);
    }
}