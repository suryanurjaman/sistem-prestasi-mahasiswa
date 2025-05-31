<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatTabelBerkasPrestasi extends Migration
{
    public function up()
    {
        Schema::create('berkas_prestasi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('prestasi_id'); // FK ke prestasi
            $table->enum('jenis_berkas', ['bukti', 'link', 'foto_upp', 'surat_tugas']);
            $table->string('nama_berkas')->nullable(); // nama file/link
            $table->string('path_berkas')->nullable(); // path file (jika file)
            $table->text('link_berkas')->nullable(); // kalau berupa URL
            $table->timestamps();

            $table->foreign('prestasi_id')->references('id')->on('prestasi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('berkas_prestasi');
    }
}
