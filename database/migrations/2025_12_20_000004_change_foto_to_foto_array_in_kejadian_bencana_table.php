<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // --- Step 1: Tambah kolom foto_temp jika belum ada ---
        Schema::table('kejadian_bencana', function (Blueprint $table) {
            if (!Schema::hasColumn('kejadian_bencana', 'foto_temp')) {
                $table->json('foto_temp')->nullable()->after('keterangan');
            }
        });

        // --- Step 2: Pindahkan data foto lama jika kolom foto masih ada ---
        if (Schema::hasColumn('kejadian_bencana', 'foto')) {

            $kejadians = DB::table('kejadian_bencana')
                ->whereNotNull('foto')
                ->get();

            foreach ($kejadians as $kejadian) {

                $fotoData = $kejadian->foto;

                if (empty($fotoData)) {
                    continue;
                }

                // Cek apakah sudah JSON
                $decoded = json_decode($fotoData, true);

                if (json_last_error() === JSON_ERROR_NONE) {
                    // sudah JSON
                    $newValue = $decoded;
                } else {
                    // bukan JSON, jadikan array
                    $newValue = [$fotoData];
                }

                DB::table('kejadian_bencana')
                    ->where('kejadian_id', $kejadian->kejadian_id)
                    ->update(['foto_temp' => json_encode($newValue)]);
            }

            // --- Step 3: Hapus kolom foto lama ---
            Schema::table('kejadian_bencana', function (Blueprint $table) {
                if (Schema::hasColumn('kejadian_bencana', 'foto')) {
                    $table->dropColumn('foto');
                }
            });
        }

        // --- Step 4: Rename foto_temp menjadi foto (jika belum diganti) ---
        if (Schema::hasColumn('kejadian_bencana', 'foto_temp') &&
            !Schema::hasColumn('kejadian_bencana', 'foto')) {

            DB::statement(
                "ALTER TABLE kejadian_bencana CHANGE foto_temp foto JSON NULL"
            );
        }
    }

    public function down(): void
    {
        // --- Rollback aman ---
        Schema::table('kejadian_bencana', function (Blueprint $table) {
            if (!Schema::hasColumn('kejadian_bencana', 'foto_temp')) {
                $table->string('foto_temp')->nullable();
            }
        });

        if (Schema::hasColumn('kejadian_bencana', 'foto')) {
            $kejadians = DB::table('kejadian_bencana')
                ->whereNotNull('foto')->get();

            foreach ($kejadians as $kejadian) {
                $arr = json_decode($kejadian->foto, true);
                $first = is_array($arr) ? ($arr[0] ?? null) : null;

                DB::table('kejadian_bencana')
                    ->where('kejadian_id', $kejadian->kejadian_id)
                    ->update(['foto_temp' => $first]);
            }

            Schema::table('kejadian_bencana', function (Blueprint $table) {
                $table->dropColumn('foto');
            });

            DB::statement(
                "ALTER TABLE kejadian_bencana CHANGE foto_temp foto VARCHAR(255) NULL"
            );
        }
    }
};
