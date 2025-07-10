<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('evaluation_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('org_term_id');
            $table->unsignedBigInteger('user_id');
            $table->float('score')->nullable();
            $table->unsignedBigInteger('rank_id')->nullable();
            $table->timestamps();
            $table->unique(['org_term_id', 'user_id']);
            $table->foreign('org_term_id')->references('id')->on('org_terms')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('rank_id')->references('id')->on('award_ranks')->onDelete('set null');
        });
    }
    public function down() {
        Schema::dropIfExists('evaluation_results');
    }
};
