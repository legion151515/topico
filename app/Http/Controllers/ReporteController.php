<?php

namespace App\Http\Controllers;

use App\Models\Atencion;
use App\Models\Paciente;
use App\Models\Medicamento;
use App\Models\MotivoConsulta;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index()
    {
        return view('reportes.index');
    }

    public function area()
    {
        $atenciones = Atencion::with('paciente')->get();
        
        $areas = $atenciones->groupBy('paciente.carrera')->map(function($group) {
            return $group->count();
        });

        return view('reportes.area', compact('areas'));
    }

    public function enfermedad()
    {
        $atenciones = Atencion::with('motivo')->get();
        
        $enfermedades = $atenciones->groupBy(function($atencion) {
            return $atencion->motivo->nombre ?? $atencion->motivo_otro;
        })->map(function($group) {
            return $group->count();
        });

        return view('reportes.enfermedad', compact('enfermedades'));
    }

    public function stock()
    {
        $medicamentos = Medicamento::where('cantidad_stock', '<', 'stock_minimo_alerta')->get();
        return view('reportes.stock', compact('medicamentos'));
    }
}