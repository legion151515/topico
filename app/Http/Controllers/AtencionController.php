<?php

namespace App\Http\Controllers;

use App\Models\Atencion;
use App\Models\Paciente;
use App\Models\MotivoConsulta;
use App\Models\Medicamento;
use Illuminate\Http\Request;

class AtencionController extends Controller
{
    public function index()
    {
        $atenciones = Atencion::with(['paciente.carrera', 'motivo', 'medicamentos'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('atenciones.index', compact('atenciones'));
    }

    public function create()
    {
        $motivos = MotivoConsulta::all();
        $medicamentos = Medicamento::all();
        return view('atenciones.create', compact('motivos', 'medicamentos'));
    }

    public function store(Request $request)
{
    // DEBUG COMPLETO
    \Log::info('=== DEBUG STORE ===');
    \Log::info('Request DNI:', ['dni' => $request->dni]);
    \Log::info('Request Nombre:', ['nombre' => $request->nombre]);
    \Log::info('Request Apellido:', ['apellido' => $request->apellido]);
    \Log::info('Request Edad:', ['edad' => $request->edad]);

    // Validar que el DNI no esté vacío
    if (empty($request->dni)) {
        return redirect()->back()->withErrors(['dni' => 'El DNI es obligatorio']);
    }

    try {
        // Buscar paciente
        $paciente = Paciente::where('dni', $request->dni)->first();
        \Log::info('Paciente encontrado:', ['existe' => $paciente ? 'SI' : 'NO']);

        if ($paciente) {
            // Si existe, ACTUALIZAR
            \Log::info('Actualizando paciente...');
            $paciente->update([
                'nombre' => $request->nombre ?? $paciente->nombre,
                'apellido' => $request->apellido ?? $paciente->apellido,
                'carrera_id' => $request->carrera_id ?? $paciente->carrera_id,
                'otros_especificacion' => $request->otros_especificacion ?? $paciente->otros_especificacion,
                'edad' => $request->edad ?? $paciente->edad
            ]);
            \Log::info('Paciente actualizado correctamente');
        } else {
            // Si no existe, CREAR
            \Log::info('Creando paciente nuevo...');
            $paciente = Paciente::create([
                'dni' => $request->dni,
                'nombre' => $request->nombre ?? 'SIN NOMBRE',
                'apellido' => $request->apellido ?? 'SIN APELLIDO',
                'carrera_id' => $request->carrera_id,
                'otros_especificacion' => $request->otros_especificacion,
                'edad' => $request->edad ?? 0
            ]);
            \Log::info('Paciente creado correctamente', ['id' => $paciente->id]);
        }
    } catch (\Exception $e) {
        \Log::error('Error en paciente:', ['error' => $e->getMessage()]);
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
    
    // Crear atención
    $atencion = Atencion::create([
        'paciente_id' => $paciente->id,
        'motivo_id' => $request->motivo_id,
        'motivo_otro' => $request->motivo_otro,
        'fecha' => $request->fecha ?? now()->format('Y-m-d'),
        'hora_entrada' => $request->hora_entrada,
        
        'hora_salida' => \Carbon\Carbon::parse($request->hora_salida)->subHours(5)->format('H:i:s'),
        'tipo_salida' => $request->tipo_salida ?? 'Manual',
    ]);
    
    if ($request->has('medicamentos')) {
        foreach ($request->medicamentos as $med_id => $cantidad) {
            if ($cantidad > 0) {
                $atencion->medicamentos()->attach($med_id, ['cantidad_usada' => $cantidad]);
            }
        }
    }
    
    return redirect()->route('atenciones.index')->with('success', 'Atención registrada correctamente');
}

    public function show(string $id)
    {
        $atencion = Atencion::with(['paciente.carrera', 'motivo', 'medicamentos'])->findOrFail($id);
        return view('atenciones.show', compact('atencion'));
    }

    public function edit(string $id)
    {
        $atencion = Atencion::find($id);
        $motivos = MotivoConsulta::all();
        $medicamentos = Medicamento::all();
        return view('atenciones.edit', compact('atencion', 'motivos', 'medicamentos'));
    }

    public function update(Request $request, string $id)
    {
        $atencion = Atencion::find($id);
        $atencion->update($request->all());
        return redirect()->route('atenciones.index')->with('success', 'Atención actualizada');
    }
    public function buscarPaciente($dni)
    {
        $paciente = Paciente::with('carrera')->where('dni', $dni)->first();

        if ($paciente) {
            return response()->json([
                'encontrado' => true,
                'nombre' => $paciente->nombre,
                'apellido' => $paciente->apellido,
                'edad' => $paciente->edad,
                'carrera_id' => $paciente->carrera_id,
                'categoria' => $paciente->carrera ? $paciente->carrera->categoria : null,
                'otros_especificacion' => $paciente->otros_especificacion
            ]);
        }

        return response()->json(['encontrado' => false]);
    }

    public function destroy(string $id)
{
    $atencion = Atencion::find($id);
    $atencion->medicamentos()->detach();
    $atencion->delete();
    return redirect()->route('atenciones.index')->with('success', 'Atención eliminada correctamente');
}
}