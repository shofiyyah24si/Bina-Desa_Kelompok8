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
            $table->string('foto')->nullable()->after('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('kejadian_bencana', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
};
