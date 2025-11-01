<?php

namespace App\Http\Controllers;

use App\Models\Atencion;
use App\Models\Paciente;
use App\Models\Medicamento;
use App\Models\MotivoConsulta;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function index()
    {
        return view('reportes.index');
    }

    public function area()
    {
        $atenciones = Atencion::with('paciente.carrera')->get();

        $areas = $atenciones->groupBy(function($atencion) {
            if ($atencion->paciente && $atencion->paciente->carrera) {
                return $atencion->paciente->carrera->nombre;
            }
            return $atencion->paciente->otros_especificacion ?? 'Sin especificar';
        })->map(function($group) {
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
        $medicamentos = Medicamento::whereRaw('cantidad_stock < stock_minimo_alerta')->get();
        return view('reportes.stock', compact('medicamentos'));
    }

    // Generar PDF de reporte por área
    public function areaPDF()
    {
        $atenciones = Atencion::with('paciente.carrera')->get();

        $areas = $atenciones->groupBy(function($atencion) {
            if ($atencion->paciente && $atencion->paciente->carrera) {
                return $atencion->paciente->carrera->nombre;
            }
            return $atencion->paciente->otros_especificacion ?? 'Sin especificar';
        })->map(function($group) {
            return $group->count();
        });

        $pdf = Pdf::loadView('reportes.area-pdf', compact('areas'));
        return $pdf->download('Reporte_Atenciones_Area_' . date('Y-m-d') . '.pdf');
    }

    // Generar PDF de reporte por enfermedad
    public function enfermedadPDF()
    {
        $atenciones = Atencion::with('motivo')->get();

        $enfermedades = $atenciones->groupBy(function($atencion) {
            return $atencion->motivo->nombre ?? $atencion->motivo_otro;
        })->map(function($group) {
            return $group->count();
        });

        $pdf = Pdf::loadView('reportes.enfermedad-pdf', compact('enfermedades'));
        return $pdf->download('Reporte_Enfermedades_' . date('Y-m-d') . '.pdf');
    }

    // Generar PDF de reporte de stock
    public function stockPDF()
    {
        $medicamentos = Medicamento::whereRaw('cantidad_stock < stock_minimo_alerta')->get();

        $pdf = Pdf::loadView('reportes.stock-pdf', compact('medicamentos'));
        return $pdf->download('Reporte_Stock_Bajo_' . date('Y-m-d') . '.pdf');
    }
}