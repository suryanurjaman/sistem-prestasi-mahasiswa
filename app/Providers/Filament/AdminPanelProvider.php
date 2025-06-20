<?php

namespace App\Providers\Filament;

use App\Filament\Pages\CustomLogin;
use App\Http\Middleware\RedirectToProperPanelMiddleware;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
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
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Filament\Navigation\MenuItem;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Illuminate\Support\Facades\Route;
use Filament\Pages\Auth\Login;

use Filament\Pages\Auth\Login as BaseLogin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('dashboard')
            ->login(CustomLogin::class)
            ->authGuard('admin')

            ->brandLogo(fn() => Route::is('filament.admin.auth.login') ? view('filament.admin.login-header') : view('filament.admin.logo'))

            ->registration()
            ->colors([
                'primary' => '#69084D',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
            ->authMiddleware([
                RedirectToProperPanelMiddleware::class,
                Authenticate::class,
            ])
            ->plugins([
                FilamentEditProfilePlugin::make()
                    ->slug('profil-saya')
                    ->setTitle('Edit Profil')
                    ->setNavigationLabel('Edit Profil')
                    ->setIcon('heroicon-o-user')
                    ->shouldRegisterNavigation(false) // ⛔️ supaya TIDAK muncul di sidebar
                    ->shouldShowEmailForm()
                    ->shouldShowDeleteAccountForm()
            ])
            ->userMenuItems([
                'edit-profile' => MenuItem::make()
                    ->label('Edit Profil')
                    ->url(fn() => EditProfilePage::getUrl())
                    ->icon('heroicon-o-cog'),
            ])
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s');
    }
}
