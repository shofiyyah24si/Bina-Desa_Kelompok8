<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('logistik_bencana', function (Blueprint $table) {
            $table->id('logistik_id');

            $table->unsignedInteger('kejadian_id');
            $table->string('nama_barang');
            $table->string('satuan', 50)->nullable();
            $table->integer('stok')->default(0);
            $table->string('sumber')->nullable();

            $table->timestamps();

            $table->foreign('kejadian_id')
                ->references('kejadian_id')
                ->on('kejadian_bencana')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logistik_bencana');
    }
};
