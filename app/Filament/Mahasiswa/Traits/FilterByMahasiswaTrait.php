<?php

namespace App\Filament\Mahasiswa\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FilterByMahasiswaTrait
{
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = auth()->user();

        if (!$user || !$user->mahasiswa) {
            return $query->whereRaw('1 = 0'); // no data
        }

        $mahasiswaId = $user->mahasiswa->id;

        $model = static::getModel();
        $table = (new $model)->getTable();

        if ($table === 'mahasiswa') {
            return $query->where('id', $mahasiswaId);
        }

        if ($table === 'prestasi') {
            return $query->where('mahasiswa_id', $mahasiswaId);
        }

        // Contoh: untuk berkas_prestasi, filter lewat relasi prestasi
        if ($table === 'berkas_prestasi') {
            return $query->whereHas('prestasi', function ($q) use ($mahasiswaId) {
                $q->where('mahasiswa_id', $mahasiswaId);
            });
        }

        // Default fallback: jika tabel lain, coba pakai kolom mahasiswa_id kalau ada
        return $query->where('mahasiswa_id', $mahasiswaId);
    }
}
