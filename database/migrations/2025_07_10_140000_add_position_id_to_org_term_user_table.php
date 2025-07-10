<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('org_term_user', function (Blueprint $table) {
            $table->foreignId('position_id')->after('user_id')->constrained('positions')->onDelete('cascade');
            $table->unique(['org_term_id', 'position_id', 'user_id']);
        });
    }
    public function down() {
        Schema::table('org_term_user', function (Blueprint $table) {
            $table->dropForeign(['position_id']);
            $table->dropColumn('position_id');
            $table->dropUnique(['org_term_id', 'position_id', 'user_id']);
        });
    }
};
