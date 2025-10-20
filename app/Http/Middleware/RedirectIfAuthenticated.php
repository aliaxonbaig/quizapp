<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     * Redirects already authenticated users to their appropriate panel.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                // Redirect to appropriate panel based on role
                if ($user->hasRole('teacher')) {
                    // Teachers default to admin panel
                    return redirect('/admin');
                } elseif ($user->hasRole('student')) {
                    // Students go to member panel
                    return redirect('/member');
                }
                
                // Fallback to default home route
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
