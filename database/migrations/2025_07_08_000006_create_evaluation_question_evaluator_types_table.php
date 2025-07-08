<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('evaluation_question_evaluator_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('evaluation_questions')->onDelete('cascade');
            $table->string('evaluator_type'); // Adviser, Peer, Self, LengthOfService
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('evaluation_question_evaluator_types');
    }
};
