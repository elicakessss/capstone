<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('evaluation_strands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('domain_id')->constrained('evaluation_domains')->onDelete('cascade');
            $table->string('name');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('evaluation_strands');
    }
};
