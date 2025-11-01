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
        Schema::create('atencion_medicamento', function (Blueprint $table) {
        $table->id();
        $table->foreignId('atencion_id')->constrained('atencions');
        $table->foreignId('medicamento_id')->constrained('medicamentos');
        $table->integer('cantidad_usada');
        $table->text('observaciones')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atencion_medicamento');
    }
};
