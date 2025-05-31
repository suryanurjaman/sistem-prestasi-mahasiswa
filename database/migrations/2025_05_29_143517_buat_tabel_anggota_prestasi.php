<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatTabelAnggotaPrestasi extends Migration
{
    public function up()
    {
        Schema::create('anggota_prestasi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('prestasi_id'); // FK ke prestasi
            $table->uuid('mahasiswa_id'); // FK ke mahasiswa sebagai anggota
            $table->string('peran')->nullable(); // contoh: ketua, anggota
            $table->timestamps();

            $table->foreign('prestasi_id')->references('id')->on('prestasi')->onDelete('cascade');
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('anggota_prestasi');
    }
}
