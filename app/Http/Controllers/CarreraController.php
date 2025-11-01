<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    public function index()
    {
        $carreras = Carrera::all();
        return view('carreras.index', compact('carreras'));
    }

    public function create()
    {
        return view('carreras.create');
    }

    public function store(Request $request)
    {
        // Validación básica
        $request->validate([
            'categoria' => 'required',
            'nombre' => 'required',
        ]);

        Carrera::create([
            'categoria' => $request->categoria,
            'nombre' => $request->nombre,
            'acronimo' => $request->acronimo ?? null,
            'anios' => $request->anios ?? null,
            'grado' => $request->grado ?? null,
        ]);

        return redirect()->route('carreras.index')->with('success', 'Carrera creada correctamente');
    }

    public function show(Carrera $carrera)
    {
        $carrera->load('pacientes');
        return view('carreras.show', compact('carrera'));
    }

    public function edit(Carrera $carrera)
    {
        return view('carreras.edit', compact('carrera'));
    }

    public function update(Request $request, Carrera $carrera)
    {
        $carrera->update($request->all());
        return redirect()->route('carreras.index')->with('success', 'Carrera actualizada');
    }

    public function destroy(Carrera $carrera)
    {
        // Verificar si tiene pacientes asociados
        if ($carrera->pacientes()->count() > 0) {
            return redirect()->route('carreras.index')
                ->with('error', 'No se puede eliminar la carrera porque tiene pacientes asociados');
        }

        $carrera->delete();
        return redirect()->route('carreras.index')->with('success', 'Carrera eliminada');
    }

    public function obtenerPorCategoria($categoria)
    {
        $carreras = Carrera::where('categoria', $categoria)->get();
        return response()->json($carreras);
    }
}