<?php

namespace App\Http\Controllers;

use App\Models\MotivoConsulta;
use Illuminate\Http\Request;

class MotivoConsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $motivos = MotivoConsulta::orderBy('nombre')->get();
        return view('motivos.index', compact('motivos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('motivos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:motivo_consultas,nombre',
            'descripcion' => 'nullable|string|max:1000'
        ], [
            'nombre.required' => 'El nombre del motivo es obligatorio',
            'nombre.unique' => 'Ya existe un motivo con este nombre',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres',
            'descripcion.max' => 'La descripción no puede exceder 1000 caracteres'
        ]);

        MotivoConsulta::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('motivos.index')
            ->with('success', '✅ Motivo de consulta creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(MotivoConsulta $motivo)
    {
        return view('motivos.show', compact('motivo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MotivoConsulta $motivo)
    {
        return view('motivos.edit', compact('motivo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MotivoConsulta $motivo)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:motivo_consultas,nombre,' . $motivo->id,
            'descripcion' => 'nullable|string|max:1000'
        ], [
            'nombre.required' => 'El nombre del motivo es obligatorio',
            'nombre.unique' => 'Ya existe un motivo con este nombre',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres',
            'descripcion.max' => 'La descripción no puede exceder 1000 caracteres'
        ]);

        $motivo->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('motivos.index')
            ->with('success', '✅ Motivo de consulta actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MotivoConsulta $motivo)
    {
        try {
            $motivo->delete();
            return redirect()->route('motivos.index')
                ->with('success', '✅ Motivo de consulta eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('motivos.index')
                ->with('error', '❌ No se puede eliminar este motivo porque está siendo usado en atenciones registradas');
        }
    }
}
