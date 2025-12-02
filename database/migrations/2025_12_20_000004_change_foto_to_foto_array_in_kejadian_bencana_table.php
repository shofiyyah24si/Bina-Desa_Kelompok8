<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Create temporary column for JSON
        Schema::table('kejadian_bencana', function (Blueprint $table) {
            $table->json('foto_temp')->nullable()->after('keterangan');
        });
        
        // Step 2: Migrate existing foto data to foto_temp array
        DB::table('kejadian_bencana')->whereNotNull('foto')->get()->each(function ($kejadian) {
            $fotoData = $kejadian->foto;
            if (!empty($fotoData)) {
                // Check if already JSON
                $decoded = json_decode($fotoData, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    // It's a string, convert to array
                    DB::table('kejadian_bencana')
                        ->where('kejadian_id', $kejadian->kejadian_id)
                        ->update(['foto_temp' => json_encode([$fotoData])]);
                } else {
                    // Already JSON
                    DB::table('kejadian_bencana')
                        ->where('kejadian_id', $kejadian->kejadian_id)
                        ->update(['foto_temp' => $fotoData]);
                }
            }
        });
        
        // Step 3: Drop old foto column
        Schema::table('kejadian_bencana', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
        
        // Step 4: Rename foto_temp to foto
        DB::statement('ALTER TABLE kejadian_bencana CHANGE foto_temp foto JSON NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Create temporary string column
        Schema::table('kejadian_bencana', function (Blueprint $table) {
            $table->string('foto_temp')->nullable()->after('keterangan');
        });
        
        // Migrate back: take first element from JSON array
        DB::table('kejadian_bencana')->whereNotNull('foto')->get()->each(function ($kejadian) {
            $fotoArray = json_decode($kejadian->foto, true);
            if (!empty($fotoArray) && is_array($fotoArray)) {
                DB::table('kejadian_bencana')
                    ->where('kejadian_id', $kejadian->kejadian_id)
                    ->update(['foto_temp' => $fotoArray[0] ?? null]);
            }
        });
        
        // Drop JSON column
        Schema::table('kejadian_bencana', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
        
        // Rename back
        DB::statement('ALTER TABLE kejadian_bencana CHANGE foto_temp foto VARCHAR(255) NULL');
    }
};

