<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revisi extends Model
{
    use HasFactory;

    protected $table = 'revisi';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'prestasi_id',
        'catatan',
        'status',
    ];

    // Relasi ke Prestasi
    public function prestasi()
    {
        return $this->belongsTo(Prestasi::class, 'prestasi_id');
    }
}
