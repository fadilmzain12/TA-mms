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
        // Only run this after the divisions and positions tables exist
        Schema::table('members', function (Blueprint $table) {
            // Add foreign key constraints now that the tables exist
            $table->foreign('division_id')->references('id')->on('divisions')->nullOnDelete();
            $table->foreign('position_id')->references('id')->on('positions')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Drop the foreign keys
            $table->dropForeign(['division_id']);
            $table->dropForeign(['position_id']);
        });
    }
};
