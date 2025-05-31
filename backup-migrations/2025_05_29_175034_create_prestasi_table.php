<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabelPrestasiV2 extends Migration
{
    public function up()
    {
        Schema::create('prestasi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('mahasiswa_id'); // FK ke mahasiswa
            $table->string('nama_prestasi');
            $table->string('nama_prestasi_en');
            $table->enum('tingkat', ['Internasional', 'Nasional', 'Provinsi', 'Kota', 'Universitas']);
            $table->enum('jenis_juara', ['Juara 1', 'Juara 2', 'Juara 3', 'Harapan', 'Peserta']);
            $table->string('tahun', 4);
            $table->enum('jumlah_pt', ['<5', '10-20', '>20']);
            $table->enum('jumlah_provinsi', ['1-5', '5-10']);
            $table->enum('jenis_prestasi', ['Akademik', 'Non-akademik']);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('kategori_prestasi', ['Individu', 'Kelompok']);
            $table->string('dosen_pembimbing')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('pesan_admin')->nullable();
            $table->timestamps();

            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prestasi');
    }
}
