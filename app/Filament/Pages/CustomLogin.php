<?php

// app/Filament/Pages/CustomLogin.php
namespace App\Filament\Pages;

use Illuminate\Contracts\Support\Htmlable;
use Filament\Pages\Auth\Login as BaseLogin;

class CustomLogin extends BaseLogin
{
    protected static string $routePath = 'login'; // menggantikan default

    public function getHeading(): string|Htmlable
    {
        return false;
    }

    public function getTitle(): string|Htmlable
    {
        return false;
    }

    public function getSubheading(): string|Htmlable
    {
        return false;
    }
    protected function getFormSchema(): array
    {
        return [
            // Kamu bisa desain ulang form-nya di sini
            \Filament\Forms\Components\TextInput::make('email')
                ->label('Email')
                ->required()
                ->email(),

            \Filament\Forms\Components\TextInput::make('password')
                ->label('Kata Sandi')
                ->password()
                ->required(),

            \Filament\Forms\Components\Checkbox::make('remember')
                ->label('Ingat saya'),
        ];
    }
}
