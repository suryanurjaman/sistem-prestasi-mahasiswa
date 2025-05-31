<?php

namespace App\Filament\Mahasiswa\Resources\BerkasPrestasiResource\Pages;

use App\Filament\Mahasiswa\Resources\BerkasPrestasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBerkasPrestasi extends EditRecord
{
    protected static string $resource = BerkasPrestasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
