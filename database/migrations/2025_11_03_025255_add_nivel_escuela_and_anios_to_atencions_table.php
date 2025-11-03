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
            $table->string('nivel_escuela')->nullable()->after('grado')
                ->comment('Nivel de escuela: INICIAL, PRIMARIA o SECUNDARIA');
            $table->string('anios')->nullable()->after('nivel_escuela')
                ->comment('Años del estudiante (solo para nivel INICIAL)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('atencions', function (Blueprint $table) {
            $table->dropColumn(['nivel_escuela', 'anios']);
        });
    }
};
