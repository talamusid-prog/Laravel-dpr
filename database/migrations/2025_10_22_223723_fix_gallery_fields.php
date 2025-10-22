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
            // Make image field nullable
            $table->string('image')->nullable()->change();
            
            // Drop photographer column if it exists
            if (Schema::hasColumn('galleries', 'photographer')) {
                $table->dropColumn('photographer');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            // Revert image field to not nullable
            $table->string('image')->nullable(false)->change();
            
            // Add back photographer column
            $table->string('photographer')->nullable();
        });
    }
};
