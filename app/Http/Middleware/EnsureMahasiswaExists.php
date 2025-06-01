<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Filament\Notifications\Notification;

class EnsureMahasiswaExists
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->mahasiswa) {
            Notification::make()
                ->title('Data Mahasiswa belum lengkap')
                ->body('Silakan lengkapi data Mahasiswa terlebih dahulu.')
                ->danger()
                ->persistent()
                ->send();

            return redirect()->route('filament.mahasiswa.resources.mahasiswas.create');
        }

        return $next($request);
    }
}
