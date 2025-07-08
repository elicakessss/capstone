<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('org_terms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('org_id');
            $table->string('academic_year', 20);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->unique(['org_id', 'academic_year']);
            $table->foreign('org_id')->references('id')->on('orgs')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('org_terms');
    }
};
