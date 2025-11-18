<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('kejadian_bencana', function (Blueprint $table) {
        $table->enum('status_kejadian', [
            'Dilaporkan',
            'Diproses',
            'Verifikasi',
            'Selesai'
        ])->change();
    });
}

public function down()
{
    Schema::table('kejadian_bencana', function (Blueprint $table) {
        $table->enum('status_kejadian', [
            'Dilaporkan',
            'Diproses',
            'Selesai'
        ])->change();
    });
}

};
