<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Carrera;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pacientes = Paciente::with('carrera')->orderBy('created_at', 'desc')->paginate(15);
        return view('pacientes.index', compact('pacientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $carreras = Carrera::all();
        return view('pacientes.create', compact('carreras'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Determinar carrera_id según categoría
        $carreraId = null;
        if ($request->categoria === 'Otros' || $request->categoria === 'Escuela') {
            // Para "Otros" y "Escuela", carrera_id debe ser NULL
            $carreraId = null;
        } else {
            // Para Tecnológico y Pedagógico, usar el carrera_id enviado
            $carreraId = $request->carrera_id;
        }

        $validated = $request->validate([
            'dni' => 'required|unique:pacientes|max:20',
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'edad' => 'required|integer|min:0|max:150',
            'otros_especificacion' => 'nullable|max:255'
        ]);

        // Agregar carrera_id determinado según categoría
        $validated['carrera_id'] = $carreraId;

        Paciente::create($validated);

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
        $paciente = Paciente::findOrFail($id);
        $carreras = Carrera::all();
        return view('pacientes.edit', compact('paciente', 'carreras'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $paciente = Paciente::findOrFail($id);

        // Determinar carrera_id según categoría
        $carreraId = null;
        if ($request->categoria === 'Otros' || $request->categoria === 'Escuela') {
            // Para "Otros" y "Escuela", carrera_id debe ser NULL
            $carreraId = null;
        } else {
            // Para Tecnológico y Pedagógico, usar el carrera_id enviado
            $carreraId = $request->carrera_id;
        }

        $validated = $request->validate([
            'dni' => 'required|max:20|unique:pacientes,dni,' . $id,
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'edad' => 'required|integer|min:0|max:150',
            'otros_especificacion' => 'nullable|max:255'
        ]);

        // Agregar carrera_id determinado según categoría
        $validated['carrera_id'] = $carreraId;

        $paciente->update($validated);

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
