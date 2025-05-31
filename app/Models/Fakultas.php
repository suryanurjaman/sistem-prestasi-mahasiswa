<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Fakultas extends Model
{
    use HasFactory;

    protected $table = 'fakultas';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'nama',
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
        return $this->hasMany(Mahasiswa::class, 'fakultas_id');
    }

    // Relasi ke Program Studi
    public function programStudi()
    {
        return $this->hasMany(ProgramStudi::class, 'fakultas_id');
    }
}
