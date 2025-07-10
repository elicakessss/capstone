<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('evaluation_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('org_term_id')->constrained('org_terms')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Student being evaluated
            $table->foreignId('evaluator_id')->constrained('users')->onDelete('cascade'); // Who is evaluating
            $table->foreignId('question_id')->constrained('evaluation_questions')->onDelete('cascade');
            $table->float('score');
            $table->timestamps();
            $table->unique(['org_term_id', 'user_id', 'evaluator_id', 'question_id'], 'unique_response');
        });
    }
    public function down() {
        Schema::dropIfExists('evaluation_responses');
    }
};
