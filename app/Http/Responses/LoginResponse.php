<?php

namespace App\Http\Responses;

use Filament\Pages\Dashboard;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;
use Filament\Http\Responses\Auth\LoginResponse as BaseLoginResponse;

class LoginResponse extends BaseLoginResponse
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        // GUNAKAN guard() dari request Filament
        $user = filament()->auth()->user();

        if (! $user) {
            return redirect()->route('login')->withErrors([
                'email' => 'Gagal login. Silakan periksa email dan password Anda.',
            ]);
        }

        return match ($user->role) {
            'admin' => redirect()->to(Dashboard::getUrl(panel: 'admin')),
            'mahasiswa' => redirect()->to(Dashboard::getUrl(panel: 'mahasiswa')),
            default => redirect()->route('login')->withErrors([
                'role' => 'Role user tidak valid.',
            ]),
        };
    }
}
