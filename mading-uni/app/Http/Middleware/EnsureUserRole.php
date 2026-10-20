<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Pemakaian di route:
     *   ->middleware('role:super_admin')
     *   ->middleware('role:super_admin,university_admin')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(401);
        }

        $userRole = $user->role->value ?? $user->role;

        if (! in_array($userRole, $roles, true)) {
            abort(403, 'Akses ditolak. Role kamu tidak diizinkan.');
        }

        return $next($request);
    }
}