<?php

namespace App\Filament\Resources\InputPrestasiResource\Pages;

use App\Filament\Resources\InputPrestasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInputPrestasis extends ListRecords
{
    protected static string $resource = InputPrestasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
