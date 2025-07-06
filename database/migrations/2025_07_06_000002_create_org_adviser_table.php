<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('org_adviser', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('org_id');
            $table->unsignedBigInteger('adviser_id');
            $table->foreign('org_id')->references('id')->on('orgs')->onDelete('cascade');
            $table->foreign('adviser_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['org_id', 'adviser_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('org_adviser');
    }
};
