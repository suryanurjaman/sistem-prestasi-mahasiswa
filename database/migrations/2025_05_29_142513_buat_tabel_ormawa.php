<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatTabelOrmawa extends Migration
{
    public function up()
    {
        Schema::create('ormawa', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->enum('jenis', ['UKM', 'HIMA', 'BEM', 'LAINNYA']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ormawa');
    }
}
