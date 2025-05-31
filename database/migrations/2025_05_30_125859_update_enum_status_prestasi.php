<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // MySQL tidak bisa langsung modify enum dengan blueprint, pakai raw query
        DB::statement("ALTER TABLE prestasi MODIFY status ENUM('pending', 'approved', 'rejected', 'diajukan') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Kembalikan ke enum awal tanpa 'diajukan'
        DB::statement("ALTER TABLE prestasi MODIFY status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending'");
    }
};
