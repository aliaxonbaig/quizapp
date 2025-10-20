<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\RedirectResponse;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse
    {
        $user = auth()->user();
        
        // Determine redirect based on user role
        // Teachers can access both panels - redirect to admin by default
        if ($user->hasRole('teacher')) {
            return redirect()->to(route('filament.admin.pages.dashboard'));
        }
        
        // Students can only access member panel
        if ($user->hasRole('student')) {
            return redirect()->to(route('filament.member.pages.dashboard'));
        }
        
        // Admin-only users (no teacher/student role) go to admin panel
        if ($user->is_admin) {
            return redirect()->to(route('filament.admin.pages.dashboard'));
        }
        
        // Default fallback to member panel
        return redirect()->to(route('filament.member.pages.dashboard'));
    }
}
