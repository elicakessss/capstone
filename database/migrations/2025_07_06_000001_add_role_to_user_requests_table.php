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
        Schema::table('user_requests', function (Blueprint $table) {
            $table->string('role', 32)->after('department_id');
            $table->string('type', 32)->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_requests', function (Blueprint $table) {
            $table->dropColumn(['role', 'type']);
        });
    }
};
