<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Prestasi extends Model
{
    use HasFactory;

    protected $table = 'prestasi';

    protected $casts = [
        'anggota_kelompok' => 'array',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'mahasiswa_id',
        'tempat',
        'nama_prestasi',
        'nama_prestasi_en',
        'tingkat',
        'jenis_juara',
        'tahun',
        'jumlah_pt',
        'jumlah_provinsi',
        'jenis_prestasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'kategori_prestasi',
        'dosen_pembimbing',
        'status',
        'pesan_admin',
        'is_complete',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Relasi ke Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function berkasPrestasi()
    {
        return $this->hasOne(BerkasPrestasi::class, 'prestasi_id', 'id');
    }
}
