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
        Schema::table('galleries', function (Blueprint $table) {
            // Make image_path and thumbnail_path nullable
            $table->string('image_path')->nullable()->change();
            $table->string('thumbnail_path')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            // Revert image_path and thumbnail_path to not nullable
            $table->string('image_path')->nullable(false)->change();
            $table->string('thumbnail_path')->nullable(false)->change();
        });
    }
};
