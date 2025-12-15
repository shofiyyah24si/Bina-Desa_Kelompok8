<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('posko_bencana', function (Blueprint $table) {
            $table->id('posko_id');

            $table->unsignedInteger('kejadian_id');
            $table->string('nama');
            $table->text('alamat')->nullable();
            $table->string('kontak')->nullable();
            $table->string('penanggung_jawab')->nullable();

            $table->timestamps();

            $table->foreign('kejadian_id')->references('kejadian_id')->on('kejadian_bencana')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posko_bencana');
    }
};
