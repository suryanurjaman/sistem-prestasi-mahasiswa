<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNotifiableIdToStringInNotificationsTable extends Migration
{
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Ubah kolom notifiable_id menjadi string dengan panjang 36 (panjang UUID)
            $table->string('notifiable_id', 36)->change();
        });
    }

    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Kembalikan ke unsignedBigInteger jika rollback
            $table->unsignedBigInteger('notifiable_id')->change();
        });
    }
}
