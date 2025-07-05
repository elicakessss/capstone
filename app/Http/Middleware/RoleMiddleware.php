<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if user has any of the required roles
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Redirect based on user's actual role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('dashboard')->with('error', 'Access denied.');
            case 'adviser':
                return redirect()->route('dashboard')->with('error', 'Access denied.');
            case 'student':
                return redirect()->route('dashboard')->with('error', 'Access denied.');
            default:
                return redirect()->route('dashboard')->with('error', 'Access denied.');
        }
    }
}
