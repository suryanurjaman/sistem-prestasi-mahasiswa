<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
use App\Http\Responses\LoginResponse;
use App\Http\Responses\LogoutResponse;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    public $singletons = [
        LoginResponseContract::class => LoginResponse::class,
        LogoutResponseContract::class => LogoutResponse::class,
    ];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
