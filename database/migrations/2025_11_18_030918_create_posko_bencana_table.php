<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posko_bencana', function (Blueprint $table) {
            $table->increments('posko_id');          // PK
            $table->unsignedInteger('kejadian_id');  // FK
            $table->string('nama', 100);
            $table->text('alamat')->nullable();
            $table->string('kontak', 50)->nullable();
            $table->string('penanggung_jawab', 100)->nullable();

            // Foreign Key
            $table->foreign('kejadian_id')
                  ->references('kejadian_id')
                  ->on('kejadian_bencana')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            // Timestamps optional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posko_bencana');
    }
};
