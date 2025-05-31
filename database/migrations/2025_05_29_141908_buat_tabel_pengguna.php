<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatTabelPengguna extends Migration
{
    public function up()
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->uuid('id')->primary(); // primary key pakai UUID
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->string('kata_sandi'); // untuk password hash
            $table->enum('peran', ['mahasiswa', 'admin']); // role pengguna
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengguna');
    }
}
