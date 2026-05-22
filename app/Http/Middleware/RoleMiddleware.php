<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    // أضف PHPDoc فوق السطر
    /** @var User */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! Auth::check()) {
            abort(401);
        }

        if (! auth()->user()->Roles()->where('name', $role)->exists()) {
            return response()->json([
                'message' => 'permission denied',
            ], 403);
        }

        return $next($request);
    }
}
