<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    protected $table = 'niveles';

    protected $fillable = [
        'paciente_id',
        'categoria',
        'nivel_escuela',
        'grado',
        'anios',
        'otros_especificacion'
    ];

    /**
     * Relación: Un nivel pertenece a un paciente
     */
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
