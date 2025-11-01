<?php

namespace App\Http\Controllers;

use App\Models\Atencion;
use App\Models\Paciente;
use App\Models\Medicamento;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Pacientes atendidos hoy
        $pacientes_hoy = Atencion::whereDate('created_at', Carbon::today())->distinct('paciente_id')->count();
        
        // Medicamentos a vencer en los próximos 30 días
        $medicamentos_vencer = Medicamento::whereBetween('fecha_vencimiento', [
            Carbon::today(),
            Carbon::today()->addDays(30)
        ])->count();
        
        // Últimas 10 atenciones
        $ultimas_atenciones = Atencion::with('paciente', 'motivo')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Atenciones por área (carrera)
        $atenciones_por_area = Atencion::with('paciente')
            ->get()
            ->groupBy('paciente.carrera')
            ->map(function($group) {
                return $group->count();
            });
        
        return view('dashboard', compact('pacientes_hoy', 'medicamentos_vencer', 'ultimas_atenciones', 'atenciones_por_area'));
    }
}