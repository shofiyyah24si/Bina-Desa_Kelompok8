<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kejadian_bencana', function (Blueprint $table) {
            if (Schema::hasColumn('kejadian_bencana', 'foto')) {
                $table->dropColumn('foto');
            }
        });
    }

    public function down(): void
    {
        Schema::table('kejadian_bencana', function (Blueprint $table) {
            $table->json('foto')->nullable();
        });
    }
};
