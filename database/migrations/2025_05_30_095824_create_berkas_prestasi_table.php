<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('berkas_prestasi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('prestasi_id');
            $table->string('bukti_berkas')->nullable();
            $table->string('link_berkas')->nullable();
            $table->string('foto_upp')->nullable();
            $table->string('surat_tugas')->nullable();
            $table->timestamps();

            $table->foreign('prestasi_id')->references('id')->on('prestasi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berkas_prestasi');
    }
};
