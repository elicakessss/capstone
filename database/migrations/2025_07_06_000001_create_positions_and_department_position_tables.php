<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('org_id');
            $table->string('title');
            $table->timestamps();
            $table->foreign('org_id')->references('id')->on('orgs')->onDelete('cascade');
        });

        Schema::create('department_position', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('department_id');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->unique(['position_id', 'department_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('department_position');
        Schema::dropIfExists('positions');
    }
};
