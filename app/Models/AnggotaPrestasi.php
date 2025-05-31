<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaPrestasi extends Model
{
    use HasFactory;

    protected $table = 'anggota_prestasi';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'prestasi_id',
        'mahasiswa_id',
        'peran',
    ];

    // Relasi ke Prestasi
    public function prestasi()
    {
        return $this->belongsTo(Prestasi::class, 'prestasi_id');
    }

    // Relasi ke Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }
}
