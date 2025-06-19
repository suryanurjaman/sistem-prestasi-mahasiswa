<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'nim',
        'kontak',
        'fakultas_id',
        'prodi_id',
        'ormawa_id',
        'foto_mahasiswa',
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

    // Relasi ke Pengguna (User)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Fakultas
    // di App\Models\Mahasiswa.php
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id', 'id');
    }


    // Relasi ke Program Studi
    public function prodi()
    {
        return $this->belongsTo(ProgramStudi::class, 'prodi_id');
    }

    // Relasi ke Ormawa
    public function ormawa()
    {
        return $this->belongsTo(Ormawa::class, 'ormawa_id');
    }

    // Relasi ke AnggotaPrestasi (prestasi yang dia ikuti)
    public function anggotaPrestasi()
    {
        return $this->hasMany(AnggotaPrestasi::class, 'mahasiswa_id');
    }
    // Relasi ke semua prestasi mahasiswa
    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'mahasiswa_id', 'id');
    }

    public function ukm()
    {
        return $this->belongsTo(Ukm::class, 'ukm_id');
    }
}
