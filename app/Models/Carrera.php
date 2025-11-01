<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $fillable = [
        'categoria',
        'nombre',
        'acronimo',
        'anios',
        'grado'
    ];

    public function pacientes()
    {
        return $this->hasMany(Paciente::class);
    }
}