<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ukm extends Model
{
    use HasFactory;

    // Jika kamu pakai mass assignment
    protected $fillable = ['nama', 'jenis'];

    // (Opsional) Jika nama tabel berbeda dari "ukms"
    // protected $table = 'nama_tabel_ukm';

    /**
     * Relasi ke mahasiswa (jika satu UKM bisa dimiliki oleh banyak mahasiswa)
     */
    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class, 'ukm_id');
    }
}
