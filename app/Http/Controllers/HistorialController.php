<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Atencion;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class HistorialController extends Controller
{
    /**
     * Mostrar formulario de búsqueda
     */
    public function index()
    {
        return view('historial.index');
    }

    /**
     * Buscar historial por DNI
     */
    public function buscar(Request $request)
    {
        $request->validate([
            'dni' => 'required|min:8'
        ]);

        $paciente = Paciente::where('dni', $request->dni)
            ->with(['carrera', 'atenciones.motivo', 'atenciones.medicamentos'])
            ->first();

        if (!$paciente) {
            return redirect()->route('historial.index')
                ->with('error', 'No se encontró ningún paciente con el DNI: ' . $request->dni);
        }

        return view('historial.show', compact('paciente'));
    }

    /**
     * Generar PDF del historial clínico
     */
    public function generarPDF($paciente_id)
    {
        $paciente = Paciente::with(['carrera', 'atenciones.motivo', 'atenciones.medicamentos'])
            ->findOrFail($paciente_id);

        $pdf = Pdf::loadView('historial.pdf', compact('paciente'));

        $filename = 'Historial_Clinico_' . $paciente->dni . '_' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}
