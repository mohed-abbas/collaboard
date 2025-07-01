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
        Schema::create('labels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color', 7); // Hex color code like #FF5733
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['name', 'project_id']); // Ensure label names are unique within a project

            $table->index(['project_id', 'name']); // Index for faster lookups by project and name
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labels');
    }
};