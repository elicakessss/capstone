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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('id_number', 50)->unique(); // Student ID, Employee ID, etc. - Limited to 50 chars
            $table->string('first_name');
            $table->string('last_name');
            $table->string('name')->nullable(); // Full name (combination of first_name and last_name)
            $table->string('email', 191)->unique(); // Limited to 191 chars for MySQL compatibility
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_adviser')->default(false);
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
            $table->string('profile_picture')->nullable(); // Path to profile picture
            $table->text('bio')->nullable(); // Description/bio
            $table->boolean('is_active')->default(true);
            $table->json('roles')->nullable(); // JSON array of roles (multi-role support)
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email', 191)->primary(); // Limited to 191 chars for MySQL compatibility
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id', 191)->primary(); // Limited to 191 chars for MySQL compatibility
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
