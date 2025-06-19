<?php

namespace App\Filament\Resources\UkmResource\Pages;

use App\Filament\Resources\UkmResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUkm extends EditRecord
{
    protected static string $resource = UkmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
