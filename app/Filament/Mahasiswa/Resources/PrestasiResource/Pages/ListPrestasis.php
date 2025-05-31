<?php

namespace App\Filament\Mahasiswa\Resources\PrestasiResource\Pages;

use App\Filament\Mahasiswa\Resources\PrestasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPrestasis extends ListRecords
{
    protected static string $resource = PrestasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
