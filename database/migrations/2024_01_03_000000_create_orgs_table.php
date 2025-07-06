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
        Schema::create('orgs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type', 64); // Added type field
            $table->string('logo')->nullable(); // Path to logo image
            $table->text('description')->nullable();
            $table->string('term')->nullable(); // Academic term (e.g., "AY 2024-2025", "1st Semester 2024") now nullable
            $table->boolean('is_active')->default(true);
            $table->foreignId('template_id')->nullable()->constrained('orgs')->onDelete('cascade'); // Link to org template
            $table->foreignId('adviser_id')->nullable()->constrained('users')->onDelete('set null'); // Adviser who owns the org instance
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null'); // Department for the org
            $table->timestamp('evaluation_deadline')->nullable(); // When evaluation should be completed
            $table->boolean('is_evaluated')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orgs');
    }
};
