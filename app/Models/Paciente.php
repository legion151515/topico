<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $fillable = ['dni', 'nombre', 'apellido', 'edad', 'carrera_id', 'otros_especificacion'];

    public function atenciones()
    {
        return $this->hasMany(Atencion::class);
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    /**
     * Relación: Un paciente tiene UN nivel (para categorías Escuela/Otros)
     */
    public function nivel()
    {
        return $this->hasOne(Nivel::class);
    }
}