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
        Schema::create('kejadian_bencana', function (Blueprint $table) {
            $table->increments('kejadian_id');          // Primary Key

            $table->string('jenis_bencana', 100);        // Jenis bencana (banjir, gempa, dll)
            $table->date('tanggal');                     // Tanggal kejadian
            $table->text('lokasi_text')->nullable();     // Lokasi detail
            $table->string('rt', 5)->nullable();         // RT
            $table->string('rw', 5)->nullable();         // RW
            $table->string('dampak', 150)->nullable();   // Dampak (kerusakan, korban, dll)

            $table->enum('status_kejadian', [
                'Dilaporkan',
                'Diproses',
                'Verifikasi',
                'Selesai'
            ])->default('Dilaporkan');                   // Status bencana

            $table->text('keterangan')->nullable();      // Keterangan tambahan

            $table->timestamps();                        // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kejadian_bencana');
    }
};
