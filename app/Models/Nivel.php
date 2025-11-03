<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    protected $table = 'niveles';

    protected $fillable = [
        'nombre',
        'acronimo',
        'tipo'
    ];

    /**
     * Relación: Un nivel tiene muchos pacientes
     */
    public function pacientes()
    {
        return $this->hasMany(Paciente::class);
    }

    /**
     * Relación: Un nivel tiene muchas atenciones
     */
    public function atenciones()
    {
        return $this->hasMany(Atencion::class);
    }
}
