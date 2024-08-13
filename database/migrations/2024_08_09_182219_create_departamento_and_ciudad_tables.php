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
        // Create departments table
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code_dane');
            $table->timestamps();
        });

        // Create cities table
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Modify users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->date('birth_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop columns from users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropColumn(['city_id', 'birth_date', 'age']);
        });

        // Drop cities table
        Schema::dropIfExists('cities');

        // Drop departments table
        Schema::dropIfExists('departments');
    }
};
