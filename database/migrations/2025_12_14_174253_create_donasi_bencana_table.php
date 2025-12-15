<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('donasi_bencana', function (Blueprint $table) {
            $table->id('donasi_id');

            $table->unsignedInteger('kejadian_id');
            $table->string('donatur_nama')->nullable();
            $table->string('jenis'); // uang / barang
            $table->decimal('nilai', 12, 2)->nullable();

            $table->timestamps();

            $table->foreign('kejadian_id')
                  ->references('kejadian_id')
                  ->on('kejadian_bencana')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donasi_bencana');
    }
};
