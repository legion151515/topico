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
        Schema::table('atencions', function (Blueprint $table) {
            // Agregar campos que faltan del paciente como "snapshot" en la atención
            $table->string('semestre')->nullable()->after('paciente_id')->comment('Semestre del estudiante al momento de la atención');
            $table->string('grado')->nullable()->after('semestre')->comment('Grado del estudiante al momento de la atención');
            $table->string('otros_especificacion')->nullable()->after('grado')->comment('Especificación de área/cargo para categoría Otros');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('atencions', function (Blueprint $table) {
            $table->dropColumn(['semestre', 'grado', 'otros_especificacion']);
        });
    }
};
