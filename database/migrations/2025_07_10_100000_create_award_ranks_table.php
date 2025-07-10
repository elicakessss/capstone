<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('award_ranks', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., Gold, Silver, Bronze
            $table->float('min_score');
            $table->float('max_score');
            $table->integer('order')->default(0); // for display sorting
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('award_ranks');
    }
};
