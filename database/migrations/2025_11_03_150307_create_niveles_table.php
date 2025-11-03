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
        Schema::create('niveles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->unique()->constrained('pacientes')->onDelete('cascade');
            $table->enum('categoria', ['Escuela', 'Otros']);
            $table->enum('nivel_escuela', ['INICIAL', 'PRIMARIA', 'SECUNDARIA'])->nullable(); // Solo para Escuela
            $table->string('grado', 50)->nullable(); // Para PRIMARIA y SECUNDARIA
            $table->string('anios', 50)->nullable(); // Para INICIAL
            $table->string('otros_especificacion')->nullable(); // Para Otros
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('niveles');
    }
};
