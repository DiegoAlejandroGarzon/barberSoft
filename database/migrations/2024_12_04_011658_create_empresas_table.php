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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->uuid('guid')->nullable()->unique();
            $table->string('nombre');
            $table->string('ubicacion')->nullable();
            $table->string('contacto')->nullable();
            $table->boolean('status')->default(true);
            $table->string('etiqueta_empleado');
            $table->string('logo')->nullable();
            $table->string('color_one', 7)->nullable();
            $table->string('color_two', 7)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
