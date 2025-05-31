<?php

namespace App\Filament\Resources\EvaluasiPrestasiResource\Pages;

use App\Filament\Resources\EvaluasiPrestasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEvaluasiPrestasis extends ListRecords
{
    protected static string $resource = EvaluasiPrestasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
