<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatTabelRevisi extends Migration
{
    public function up()
    {
        Schema::create('revisi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('prestasi_id'); // FK ke prestasi
            $table->text('catatan_revisi');
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->timestamps();

            $table->foreign('prestasi_id')->references('id')->on('prestasi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('revisi');
    }
}
