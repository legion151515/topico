<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atencion extends Model
{
    protected $fillable = ['paciente_id', 'motivo_id', 'motivo_otro', 'fecha', 'hora_entrada', 'hora_salida', 'tipo_salida', 'token_firma', 'observaciones', 'semestre', 'grado'];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function motivo()
    {
        return $this->belongsTo(MotivoConsulta::class, 'motivo_id');
    }

    public function medicamentos()
    {
        return $this->belongsToMany(Medicamento::class, 'atencion_medicamento')->withPivot('cantidad_usada', 'observaciones');
    }
}