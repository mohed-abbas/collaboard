<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('is_system')->default(false)->after('project_id'); // For default categories like "To Do", "In Progress", etc.
            $table->integer('position')->default(0)->after('is_system'); // For ordering categories
            $table->string('color', 7)->nullable()->after('position'); // Optional: category background color

            // Add index for better performance
            $table->index(['project_id', 'position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['is_system', 'position', 'color']);
        });
    }
};