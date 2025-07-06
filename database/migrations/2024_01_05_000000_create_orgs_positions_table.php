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
        Schema::create('org_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('org_id')->constrained('orgs')->onDelete('cascade');
            $table->string('position_name', 100); // Position name entered by admin - Limited to 100 chars
            $table->text('description')->nullable(); // Optional position description
            $table->integer('slots')->default(1); // Number of available slots for this position
            $table->integer('order')->default(0); // For ordering positions in the organization
            $table->timestamps();

            // Ensure unique combination of org and position name
            $table->unique(['org_id', 'position_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_positions');
    }
};
