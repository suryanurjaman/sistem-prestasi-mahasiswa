<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BerkasPrestasi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'berkas_prestasi';

    protected $fillable = [
        'id',
        'prestasi_id',
        'bukti_berkas',
        'link_berkas',
        'foto_upp',
        'surat_tugas',
    ];

    public function getBuktiBerkasUrlAttribute()
    {
        return $this->bukti_berkas ? asset('storage/' . $this->bukti_berkas) : null;
    }

    public function getFotoUppUrlAttribute()
    {
        return $this->foto_upp ? asset('storage/' . $this->foto_upp) : null;
    }

    public function getSuratTugasUrlAttribute()
    {
        return $this->surat_tugas ? asset('storage/' . $this->surat_tugas) : null;
    }
    public function prestasi()
    {
        return $this->belongsTo(Prestasi::class);
    }
}
