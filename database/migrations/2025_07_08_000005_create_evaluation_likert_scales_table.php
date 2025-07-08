<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('evaluation_likert_scales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('evaluation_questions')->onDelete('cascade');
            $table->string('label');
            $table->float('score');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('evaluation_likert_scales');
    }
};
