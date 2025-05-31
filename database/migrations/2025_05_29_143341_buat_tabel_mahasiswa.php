<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatTabelMahasiswa extends Migration
{
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');  // FK ke tabel pengguna (user)
            $table->string('nim');
            $table->string('kontak');
            $table->uuid('fakultas_id'); // FK ke fakultas
            $table->uuid('prodi_id');    // FK ke program studi
            $table->uuid('ormawa_id')->nullable();  // FK ke ormawa, boleh null
            $table->timestamps();

            // foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('fakultas_id')->references('id')->on('fakultas')->onDelete('cascade');
            $table->foreign('prodi_id')->references('id')->on('program_studi')->onDelete('cascade');
            $table->foreign('ormawa_id')->references('id')->on('ormawa')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}
