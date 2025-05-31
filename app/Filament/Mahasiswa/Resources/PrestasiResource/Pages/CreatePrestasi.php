<?php

namespace App\Filament\Mahasiswa\Resources\PrestasiResource\Pages;

use App\Filament\Mahasiswa\Resources\PrestasiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class CreatePrestasi extends CreateRecord
{
    protected static string $resource = PrestasiResource::class;

    protected function getRedirectUrl(): string
    {
        return route('filament.mahasiswa.resources.berkas-prestasis.create', [
            'prestasi_id' => $this->record->id,
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();

        // Ambil mahasiswa yang terhubung dengan user login
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        $data['mahasiswa_id'] = $mahasiswa->id;

        $data['id'] = (string) Str::uuid();

        return $data;
    }
}
