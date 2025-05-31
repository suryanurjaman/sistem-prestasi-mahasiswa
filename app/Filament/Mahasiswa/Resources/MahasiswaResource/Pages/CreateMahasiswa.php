<?php

namespace App\Filament\Mahasiswa\Resources\MahasiswaResource\Pages;

use App\Filament\Mahasiswa\Resources\MahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateMahasiswa extends CreateRecord
{
    protected static string $resource = MahasiswaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id(); // Otomatis isi user_id dengan user yang sedang login
        return $data;
    }
}
