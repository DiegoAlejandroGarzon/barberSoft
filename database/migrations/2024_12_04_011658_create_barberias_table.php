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
        Schema::create('barberias', function (Blueprint $table) {
            $table->id();
            $table->uuid('guid')->nullable()->unique();
            $table->string('nombre');
            $table->string('ubicacion')->nullable();
            $table->string('contacto')->nullable();
            $table->boolean('status')->default(true);
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barberias');
    }
};
