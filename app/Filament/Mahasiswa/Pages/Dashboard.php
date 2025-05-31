<?php

namespace App\Filament\Mahasiswa\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends BaseDashboard
{
    protected static string $routePath = 'dashboard'; // Ganti sesuai kebutuhan
    protected static ?string $title = 'Dashboard Mahasiswa';
    protected static ?int $navigationSort = -1;

    use HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            TextInput::make('search')
                ->label('Cari')
                ->placeholder('Cari berdasarkan nama, NIM, atau kontak')
                ->live()
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state) {
                    $this->dispatchBrowserEvent('search-updated', ['query' => $state]);
                }),
        ]);
    }
}
