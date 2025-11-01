<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use Illuminate\Http\Request;

class MedicamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicamentos = Medicamento::orderBy('nombre')->paginate(15);
        return view('medicamentos.index', compact('medicamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medicamentos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable|max:500',
            'cantidad_stock' => 'required|integer|min:0',
            'stock_minimo_alerta' => 'required|integer|min:0',
            'fecha_vencimiento' => 'nullable|date'
        ]);

        Medicamento::create($validated);

        return redirect()->route('medicamentos.index')
            ->with('success', 'Medicamento registrado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $medicamento = Medicamento::with('atenciones.paciente')->findOrFail($id);
        return view('medicamentos.show', compact('medicamento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $medicamento = Medicamento::findOrFail($id);
        return view('medicamentos.edit', compact('medicamento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $medicamento = Medicamento::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable|max:500',
            'cantidad_stock' => 'required|integer|min:0',
            'stock_minimo_alerta' => 'required|integer|min:0',
            'fecha_vencimiento' => 'nullable|date'
        ]);

        $medicamento->update($validated);

        return redirect()->route('medicamentos.index')
            ->with('success', 'Medicamento actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $medicamento = Medicamento::findOrFail($id);

        // Verificar si el medicamento ha sido usado en atenciones
        if ($medicamento->atenciones()->count() > 0) {
            return redirect()->route('medicamentos.index')
                ->with('error', 'No se puede eliminar el medicamento porque ha sido usado en atenciones');
        }

        $medicamento->delete();

        return redirect()->route('medicamentos.index')
            ->with('success', 'Medicamento eliminado correctamente');
    }
}
