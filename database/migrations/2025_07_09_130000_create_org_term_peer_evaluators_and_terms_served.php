<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        // Drop the table if it exists to avoid migration errors
        if (Schema::hasTable('org_term_peer_evaluators')) {
            Schema::drop('org_term_peer_evaluators');
        }
        // Table for peer evaluator assignments per org term
        Schema::create('org_term_peer_evaluators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('org_term_id')->constrained('org_terms')->onDelete('cascade');
            $table->foreignId('peer_id')->constrained('users')->onDelete('cascade');
            $table->unsignedTinyInteger('peer_number'); // 1 or 2
            $table->timestamps();
            $table->unique(['org_term_id', 'peer_number']);
        });
        // Add terms_served to org_term_user (pivot for org_term and users)
        Schema::table('org_term_user', function (Blueprint $table) {
            if (!Schema::hasColumn('org_term_user', 'terms_served')) {
                $table->unsignedTinyInteger('terms_served')->default(0);
            }
        });
    }
    public function down() {
        Schema::dropIfExists('org_term_peer_evaluators');
        // Optionally drop terms_served column
        Schema::table('org_term_user', function (Blueprint $table) {
            if (Schema::hasColumn('org_term_user', 'terms_served')) {
                $table->dropColumn('terms_served');
            }
        });
    }
};
