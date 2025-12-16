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
        Schema::table('donasi_bencana', function (Blueprint $table) {
            if (!Schema::hasColumn('donasi_bencana', 'keterangan_barang')) {
                $table->string('keterangan_barang')->nullable()->after('nilai');
            }
        });
    }

    public function down()
    {
        Schema::table('donasi_bencana', function (Blueprint $table) {
            if (Schema::hasColumn('donasi_bencana', 'keterangan_barang')) {
                $table->dropColumn('keterangan_barang');
            }
        });
    }
};
