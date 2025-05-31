<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Filament\Pages\Dashboard;

class RedirectToProperPanelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user) {
            return $next($request);
        }

        // Jika user admin tapi akses route mahasiswa, redirect ke admin panel
        if ($user->role === 'admin' && $request->is('mahasiswa*')) {
            return redirect()->to(Dashboard::getUrl(panel: 'admin'));
        }

        // Jika user mahasiswa tapi akses route admin, redirect ke mahasiswa panel
        if ($user->role === 'mahasiswa' && $request->is('admin*')) {
            return redirect()->to(Dashboard::getUrl(panel: 'mahasiswa'));
        }

        return $next($request);
    }
}
