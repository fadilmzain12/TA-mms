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
        // For MySQL, we need to modify the column using raw SQL
        DB::statement("ALTER TABLE members MODIFY COLUMN status ENUM('pending', 'active', 'inactive', 'rejected') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original values
        DB::statement("ALTER TABLE members MODIFY COLUMN status ENUM('pending', 'active', 'rejected') DEFAULT 'pending'");
    }
};
