<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotivoConsulta extends Model
{
    protected $fillable = ['nombre', 'descripcion'];

    public function atenciones()
    {
        return $this->hasMany(Atencion::class, 'motivo_id');
    }
}