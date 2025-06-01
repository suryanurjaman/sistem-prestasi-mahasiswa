<?php

namespace App\Filament\Mahasiswa\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string $view = 'components.page.berkas-pendukung';

    protected static string $routePath = 'dashboard';
    protected static ?string $title = 'Dashboard Mahasiswa';
    protected static ?int $navigationSort = -1;
}
