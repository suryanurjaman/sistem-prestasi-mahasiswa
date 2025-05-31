<?php

namespace App\Http\Responses;

use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Filament\Http\Responses\Auth\LogoutResponse as BaseLogoutResponse;

class LogoutResponse extends BaseLogoutResponse
{
    public function toResponse($request): RedirectResponse
    {
        $panel = Filament::getCurrentPanel()->getId();

        return match ($panel) {
            'admin' => \redirect()->route('filament.admin.auth.login'),
            'mahasiswa' => \redirect()->route('filament.mahasiswa.auth.login'),
            default => \redirect('/'),
        };
    }
}
