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
    Schema::create('carreras', function (Blueprint $table) {
        $table->id();
        $table->string('categoria'); // Tecnológico, Pedagógico, Escuela, Otros
        $table->string('nombre'); // Nombre de la carrera/subcategoría
        $table->string('acronimo'); // Acrónimo corto para los selects
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carreras');
    }
};
