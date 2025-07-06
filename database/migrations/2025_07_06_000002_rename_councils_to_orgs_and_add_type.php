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
        // Rename councils to orgs and add type field
        Schema::rename('councils', 'orgs');
        Schema::table('orgs', function (Blueprint $table) {
            $table->string('type', 64)->after('name');
        });
        // Rename council_positions to org_positions and update foreign key
        Schema::rename('council_positions', 'org_positions');
        Schema::table('org_positions', function (Blueprint $table) {
            $table->renameColumn('council_id', 'org_id');
            $table->unique(['org_id', 'position_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert org_positions to council_positions and foreign key
        Schema::table('org_positions', function (Blueprint $table) {
            $table->renameColumn('org_id', 'council_id');
            $table->dropUnique(['org_id', 'position_name']);
        });
        Schema::rename('org_positions', 'council_positions');
        // Revert orgs to councils and remove type field
        Schema::table('orgs', function (Blueprint $table) {
            $table->dropColumn('type');
        });
        Schema::rename('orgs', 'councils');
    }
};
