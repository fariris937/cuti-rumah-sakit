<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        /** @var User $user */
        $user = Auth::user();

        // Debug logging for role check
        Log::info('CheckRole Middleware: User role = ' . $user->role);
        Log::info('CheckRole Middleware: Required roles = ' . $roles);

        // Split roles by comma and trim whitespace
        $roleArray = array_map('trim', explode(',', $roles));

        $hasAccess = false;

        foreach ($roleArray as $role) {
            $method = 'is' . str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $role)));
            if (method_exists($user, $method) && $user->$method()) {
                Log::info("CheckRole Middleware: User has role method $method, access granted.");
                $hasAccess = true;
                break;
            } else {
                Log::info("CheckRole Middleware: User does not have role method $method or method returned false.");
            }
        }

        if (!$hasAccess) {
            Log::warning('CheckRole Middleware: Access denied for user role ' . $user->role);
            abort(403, 'Unauthorized access. Required roles: ' . implode(', ', $roleArray));
        }

        return $next($request);
    }
}
