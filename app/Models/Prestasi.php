<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class Prestasi extends Model
{
    use HasFactory;

    protected $table = 'prestasi';

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


     // Gunakan $casts untuk tanggal
    protected $casts = [
        'anggota_kelompok' => 'array',
        'tanggal_mulai'    => 'date',
        'tanggal_selesai'  => 'date',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });

        static::deleting(function ($model) {
            if ($model->berkasPrestasi) {
                // Hapus semua file jika ada di storage
                if ($model->berkasPrestasi->bukti_berkas && Storage::exists($model->berkasPrestasi->bukti_berkas)) {
                    Storage::delete($model->berkasPrestasi->bukti_berkas);
                }
                if ($model->berkasPrestasi->foto_upp && Storage::exists($model->berkasPrestasi->foto_upp)) {
                    Storage::delete($model->berkasPrestasi->foto_upp);
                }
                if ($model->berkasPrestasi->surat_tugas && Storage::exists($model->berkasPrestasi->surat_tugas)) {
                    Storage::delete($model->berkasPrestasi->surat_tugas);
                }

                // Hapus record berkas prestasi
                $model->berkasPrestasi->delete();
            }
        });
    }

    // Relasi ke Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
    // Tambah relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function berkasPrestasi()
    {
        return $this->hasOne(BerkasPrestasi::class, 'prestasi_id', 'id');
    }
}
