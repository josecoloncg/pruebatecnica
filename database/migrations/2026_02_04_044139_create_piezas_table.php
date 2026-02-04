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
        Schema::create('piezas', function (Blueprint $table) {
            $table->id();
            $table->string('pieza', 10)->comment('Código de la pieza: B01, A02, H12, etc.');
            $table->decimal('peso_teorico', 8, 2)->comment('Peso teórico en kg');
            $table->decimal('peso_real', 8, 2)->nullable()->comment('Peso real en kg');
            $table->enum('estado', ['Pendiente', 'Fabricado'])->default('Pendiente');
            $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('cascade');
            $table->foreignId('bloque_id')->constrained('bloques')->onDelete('cascade');
            $table->timestamp('fecha_registro')->nullable();
            $table->foreignId('registrado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Índices para mejorar consultas
            $table->index(['estado', 'bloque_id']);
            $table->index('proyecto_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('piezas');
    }
};
