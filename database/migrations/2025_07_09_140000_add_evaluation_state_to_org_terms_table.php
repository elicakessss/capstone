<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('org_terms', function (Blueprint $table) {
            $table->enum('evaluation_state', ['not_started', 'in_progress', 'cancelled', 'closed'])->default('not_started')->after('academic_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('org_terms', function (Blueprint $table) {
            $table->dropColumn('evaluation_state');
        });
    }
};
