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
        Schema::create('bloques', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_bloque', 10)->comment('Ej: 1110, 2210, 3510');
            $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('cascade');
            $table->text('descripcion')->nullable();
            $table->timestamps();
            
            // Índice compuesto para evitar duplicados
            $table->unique(['nombre_bloque', 'proyecto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bloques');
    }
};
