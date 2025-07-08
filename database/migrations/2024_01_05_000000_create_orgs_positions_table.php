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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('org_id')->constrained('orgs')->onDelete('cascade');
            $table->string('title', 100); // Position title entered by admin - Limited to 100 chars
            $table->text('description')->nullable(); // Optional position description
            $table->integer('slots')->default(1); // Number of available slots for this position
            $table->integer('order')->unique(); // For ordering positions in the organization, must be unique
            $table->timestamps();

            // Ensure unique combination of org and position title
            $table->unique(['org_id', 'title']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
