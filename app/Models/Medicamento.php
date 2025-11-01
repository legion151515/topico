<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'cantidad_stock', 'stock_minimo_alerta', 'fecha_vencimiento'];

    public function atenciones()
    {
        return $this->belongsToMany(Atencion::class, 'atencion_medicamento')->withPivot('cantidad_usada', 'observaciones');
    }
}