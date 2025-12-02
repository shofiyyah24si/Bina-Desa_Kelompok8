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

            $table->string('jenis_bencana', 100);        
            $table->date('tanggal');                     
            $table->text('lokasi_text')->nullable();     
            $table->string('rt', 5)->nullable();         
            $table->string('rw', 5)->nullable();         
            $table->string('dampak', 150)->nullable();  

            $table->enum('status_kejadian', [
                'Dilaporkan',
                'Diproses',
                'Verifikasi',
                'Selesai'
            ])->default('Dilaporkan');                  

            $table->text('keterangan')->nullable();      

            $table->timestamps();                        
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
