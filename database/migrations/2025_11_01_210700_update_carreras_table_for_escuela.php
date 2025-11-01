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
        Schema::table('carreras', function (Blueprint $table) {
            // Hacer acronimo nullable para Escuela y Otros
            $table->string('acronimo')->nullable()->change();

            // Agregar campos para Escuela
            $table->string('anios')->nullable()->after('acronimo'); // Para Inicial: 3, 4, 5 años
            $table->string('grado')->nullable()->after('anios');    // Para Primaria/Secundaria: 1°, 2°, etc.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carreras', function (Blueprint $table) {
            $table->string('acronimo')->nullable(false)->change();
            $table->dropColumn(['anios', 'grado']);
        });
    }
};
