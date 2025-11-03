<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Carrera;
use App\Models\Atencion;
use App\Models\Nivel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pacientes = Paciente::with(['carrera', 'nivel'])->orderBy('created_at', 'desc')->paginate(15);
        return view('pacientes.index', compact('pacientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $carreras = Carrera::all();
        $niveles = Nivel::all();
        return view('pacientes.create', compact('carreras', 'niveles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Determinar carrera_id y nivel_id según categoría
        $carreraId = null;
        $nivelId = null;

        if ($request->categoria === 'Escuela') {
            // Para Escuela: buscar nivel por nombre (INICIAL, PRIMARIA, SECUNDARIA)
            $carreraId = null;
            if ($request->nivel_escuela) {
                $nivel = Nivel::where('nombre', $request->nivel_escuela)->where('tipo', 'Escuela')->first();
                $nivelId = $nivel ? $nivel->id : null;
            }
        } elseif ($request->categoria === 'Otros') {
            // Para Otros: buscar nivel tipo "Otros"
            $carreraId = null;
            $nivel = Nivel::where('nombre', 'OTROS')->where('tipo', 'Otros')->first();
            $nivelId = $nivel ? $nivel->id : null;
        } else {
            // Para Tecnológico y Pedagógico: usar carrera_id
            $carreraId = $request->carrera_id;
            $nivelId = null;
        }

        $validated = $request->validate([
            'dni' => 'required|unique:pacientes|max:20',
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'edad' => 'required|integer|min:0|max:150',
            'otros_especificacion' => 'nullable|max:255'
        ]);

        // Agregar carrera_id y nivel_id determinados
        $validated['carrera_id'] = $carreraId;
        $validated['nivel_id'] = $nivelId;

        // Crear el paciente
        $paciente = Paciente::create($validated);

        // Crear registro en atencions con la información adicional del paciente
        Atencion::create([
            'paciente_id' => $paciente->id,
            'categoria' => $request->categoria,
            'nivel_id' => $nivelId,
            'semestre' => $request->semestre,
            'grado' => $request->grado,
            'nivel_escuela' => $request->nivel_escuela,
            'anios' => $request->anios,
            'otros_especificacion' => $request->otros_especificacion,
            'fecha' => Carbon::now()->format('Y-m-d'),
            'hora_entrada' => Carbon::now()->format('H:i'),
            'motivo_otro' => 'Registro inicial de paciente'
        ]);

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente registrado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paciente = Paciente::with(['carrera', 'atenciones.motivo', 'atenciones.medicamentos'])->findOrFail($id);
        return view('pacientes.show', compact('paciente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $paciente = Paciente::with(['carrera', 'nivel'])->findOrFail($id);
        $carreras = Carrera::all();
        $niveles = Nivel::all();

        // Obtener la atención más reciente del paciente para recuperar los datos adicionales
        $ultimaAtencion = Atencion::where('paciente_id', $id)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('pacientes.edit', compact('paciente', 'carreras', 'niveles', 'ultimaAtencion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $paciente = Paciente::findOrFail($id);

        // Determinar carrera_id y nivel_id según categoría
        $carreraId = null;
        $nivelId = null;

        if ($request->categoria === 'Escuela') {
            // Para Escuela: buscar nivel por nombre (INICIAL, PRIMARIA, SECUNDARIA)
            $carreraId = null;
            if ($request->nivel_escuela) {
                $nivel = Nivel::where('nombre', $request->nivel_escuela)->where('tipo', 'Escuela')->first();
                $nivelId = $nivel ? $nivel->id : null;
            }
        } elseif ($request->categoria === 'Otros') {
            // Para Otros: buscar nivel tipo "Otros"
            $carreraId = null;
            $nivel = Nivel::where('nombre', 'OTROS')->where('tipo', 'Otros')->first();
            $nivelId = $nivel ? $nivel->id : null;
        } else {
            // Para Tecnológico y Pedagógico: usar carrera_id
            $carreraId = $request->carrera_id;
            $nivelId = null;
        }

        $validated = $request->validate([
            'dni' => 'required|max:20|unique:pacientes,dni,' . $id,
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'edad' => 'required|integer|min:0|max:150',
            'otros_especificacion' => 'nullable|max:255'
        ]);

        // Agregar carrera_id y nivel_id determinados
        $validated['carrera_id'] = $carreraId;
        $validated['nivel_id'] = $nivelId;

        $paciente->update($validated);

        // Crear registro en atencions con la información actualizada del paciente
        Atencion::create([
            'paciente_id' => $paciente->id,
            'categoria' => $request->categoria,
            'nivel_id' => $nivelId,
            'semestre' => $request->semestre,
            'grado' => $request->grado,
            'nivel_escuela' => $request->nivel_escuela,
            'anios' => $request->anios,
            'otros_especificacion' => $request->otros_especificacion,
            'fecha' => Carbon::now()->format('Y-m-d'),
            'hora_entrada' => Carbon::now()->format('H:i'),
            'motivo_otro' => 'Actualización de datos del paciente'
        ]);

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paciente = Paciente::findOrFail($id);

        // Verificar si tiene atenciones registradas
        if ($paciente->atenciones()->count() > 0) {
            return redirect()->route('pacientes.index')
                ->with('error', 'No se puede eliminar el paciente porque tiene atenciones registradas');
        }

        $paciente->delete();

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente eliminado correctamente');
    }
}
