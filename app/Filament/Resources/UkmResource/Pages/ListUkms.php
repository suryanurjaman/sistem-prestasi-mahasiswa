<?php

namespace App\Filament\Resources\UkmResource\Pages;

use App\Filament\Resources\UkmResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUkms extends ListRecords
{
    protected static string $resource = UkmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
