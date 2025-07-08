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
        Schema::create('department_position', function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_id')->constrained('positions')->onDelete('cascade');
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->unique(['position_id', 'department_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_position');
    }
};
