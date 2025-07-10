<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('org_term_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('org_term_id')->constrained('org_terms')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('position_id')->constrained('positions')->onDelete('cascade');
            $table->unsignedTinyInteger('terms_served')->default(0);
            $table->timestamps();
            $table->unique(['org_term_id', 'position_id', 'user_id']);
        });
    }
    public function down() {
        Schema::dropIfExists('org_term_user');
    }
};
