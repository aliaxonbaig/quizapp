<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     * Redirects users to the appropriate panel based on their role.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // Get the current panel from the URL
            $currentPath = $request->path();
            
            // If user is not active, logout and redirect to login
            if (!$user->is_active) {
                auth()->logout();
                return redirect()->route('filament.member.auth.login')
                    ->with('error', 'Your account is not active.');
            }
            
            // Check if user is trying to access admin panel
            $isAccessingAdmin = str_starts_with($currentPath, 'admin');
            $isAccessingMember = str_starts_with($currentPath, 'member');
            
            // Teachers can access both panels
            if ($user->hasRole('teacher')) {
                return $next($request);
            }
            
            // Students can only access member panel
            if ($user->hasRole('student')) {
                if ($isAccessingAdmin) {
                    return redirect('/member')->with('warning', 'You do not have access to the admin panel.');
                }
                return $next($request);
            }
            
            // Admin users (no teacher/student role) can only access admin panel
            if ($user->is_admin && !$user->hasAnyRole(['teacher', 'student'])) {
                if ($isAccessingMember) {
                    return redirect('/admin')->with('warning', 'You do not have access to the member panel.');
                }
                return $next($request);
            }
            
            // Users without proper roles should be logged out
            auth()->logout();
            return redirect()->route('filament.member.auth.login')
                ->with('error', 'You do not have the required permissions.');
        }
        
        return $next($request);
    }
}
