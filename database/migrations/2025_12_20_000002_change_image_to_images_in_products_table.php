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
        Schema::table('products', function (Blueprint $table) {
            $table->json('images')->nullable()->after('image');
        });
        
        // Migrate existing image data to images array
        DB::table('products')->whereNotNull('image')->get()->each(function ($product) {
            DB::table('products')
                ->where('id', $product->id)
                ->update(['images' => json_encode([$product->image])]);
        });
        
        // Drop old image column after migration
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('image')->nullable()->after('images');
        });
        
        // Migrate back: take first image from array
        DB::table('products')->whereNotNull('images')->get()->each(function ($product) {
            $images = json_decode($product->images, true);
            if (!empty($images)) {
                DB::table('products')
                    ->where('id', $product->id)
                    ->update(['image' => $images[0]]);
            }
        });
        
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }
};

