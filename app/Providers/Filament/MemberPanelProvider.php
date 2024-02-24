<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Auth\Register;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Livewire\RandomQuoteWidget;
use Filament\Navigation\MenuItem;
use Illuminate\Support\Facades\Auth;
use Jeffgreco13\FilamentBreezy\BreezyCore;

class MemberPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('member')
            ->path('member')
            ->login(Login::class)
            ->registration(Register::class)
            ->passwordReset()
            ->profile()
            ->sidebarCollapsibleOnDesktop()
            ->userMenuItems([
                MenuItem::make()
                ->label('Admin')
                ->icon('heroicon-o-cog-6-tooth')
                ->url('/admin')
                ->hidden(fn(): bool => ! Auth::user()->is_admin)
            ])
            ->colors([
                'primary' => Color::Blue,
            ])
            ->breadcrumbs(false)
            ->maxContentWidth('full')
            ->viteTheme('resources/css/filament/member/theme.css')
            ->discoverResources(in: app_path('Filament/Member/Resources'), for: 'App\\Filament\\Member\\Resources')
            ->discoverPages(in: app_path('Filament/Member/Pages'), for: 'App\\Filament\\Member\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->emailVerification()
            ->discoverWidgets(in: app_path('Filament/Member/Widgets'), for: 'App\\Filament\\Member\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                RandomQuoteWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                BreezyCore::make()
                    ->avatarUploadComponent(fn($fileUpload) => $fileUpload->disableLabel())
                    ->enableTwoFactorAuthentication(
                        force: false, // force the user to enable 2FA before they can use the application (default = false)
                    )
                    ->myProfile(
                        shouldRegisterUserMenu: true, // Sets the 'account' link in the panel User Menu (default = true)
                        shouldRegisterNavigation: false, // Adds a main navigation item for the My Profile page (default = false)
                        hasAvatars: true, // Enables the avatar upload form component (default = false)
                        slug: 'my-profile' // Sets the slug for the profile page (default = 'my-profile')

                    ),

            ])
            ->databaseNotifications()
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                // This line tells us where to render it
                'panels::body.end',
                // This is the view that will be rendered
                fn () => view('filament.footer.footer'),
            );
    }
}
