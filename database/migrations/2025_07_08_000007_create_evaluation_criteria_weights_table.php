<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('evaluation_criteria_weights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('evaluation_forms')->onDelete('cascade');
            $table->string('evaluator_type'); // Adviser, Peer, Self, LengthOfService
            $table->float('weight');
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('evaluation_criteria_weights');
    }
};
