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
    \Log::info('=== DEBUG STORE ATENCIÓN ===');
    \Log::info('Request COMPLETO:', $request->all());
    \Log::info('Request DNI:', ['dni' => $request->dni]);
    \Log::info('Request Nombre:', ['nombre' => $request->nombre]);
    \Log::info('Request Apellido:', ['apellido' => $request->apellido]);
    \Log::info('Request Edad:', ['edad' => $request->edad]);
    \Log::info('Request Categoria:', ['categoria' => $request->categoria]);
    \Log::info('Request Carrera ID (RAW):', [
        'carrera_id' => $request->carrera_id,
        'tipo' => gettype($request->carrera_id),
        'es_numerico' => is_numeric($request->carrera_id)
    ]);
    \Log::info('Request Otros especificacion:', ['otros_especificacion' => $request->otros_especificacion]);
    \Log::info('Request Hora Salida:', ['hora_salida' => $request->hora_salida]);
    \Log::info('Request Tipo Salida:', ['tipo_salida' => $request->tipo_salida]);

    // Validar que el DNI no esté vacío
    if (empty($request->dni)) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['dni' => 'El DNI es obligatorio']);
    }

    // ============================================
    // VALIDACIÓN Y NORMALIZACIÓN DE CARRERA_ID
    // ============================================
    $carreraId = null;

    if ($request->categoria === 'Otros' || $request->categoria === 'Escuela') {
        // Para "Otros" y "Escuela", carrera_id debe ser NULL
        // "Otros" usa otros_especificacion
        // "Escuela" usa nivel_escuela
        $carreraId = null;
        \Log::info('Categoría "' . $request->categoria . '" detectada, carrera_id = NULL');

    } else {
        // Para Tecnológico y Pedagógico, validar carrera_id
        if (empty($request->carrera_id)) {
            \Log::error('ERROR: carrera_id vacío para categoría que no es "Otros" ni "Escuela"');
            return redirect()->back()
                ->withInput()
                ->withErrors(['carrera_id' => 'Debe seleccionar una carrera para la categoría ' . $request->categoria]);
        }

        // CRÍTICO: Validar que carrera_id sea NUMÉRICO
        if (!is_numeric($request->carrera_id)) {
            \Log::error('ERROR CRÍTICO: carrera_id NO ES NUMÉRICO', [
                'carrera_id' => $request->carrera_id,
                'tipo' => gettype($request->carrera_id)
            ]);

            // Intentar buscar la carrera por nombre como fallback
            \Log::info('Intentando buscar carrera por nombre...');
            $carrera = \App\Models\Carrera::where('nombre', $request->carrera_id)
                ->orWhere('nombre', 'LIKE', '%' . $request->carrera_id . '%')
                ->first();

            if ($carrera) {
                $carreraId = $carrera->id;
                \Log::info('Carrera encontrada por nombre', ['id' => $carreraId, 'nombre' => $carrera->nombre]);
            } else {
                \Log::error('No se pudo encontrar la carrera por nombre');
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['carrera_id' => 'ERROR: El sistema recibió un nombre de carrera ("' . $request->carrera_id . '") en lugar de un ID. Por favor, recarga la página y vuelve a intentar. Si el problema persiste, contacta al administrador.']);
            }
        } else {
            $carreraId = (int) $request->carrera_id;
            \Log::info('carrera_id validado como numérico', ['id' => $carreraId]);

            // Verificar que la carrera exista en la BD
            $carreraExiste = \App\Models\Carrera::find($carreraId);
            if (!$carreraExiste) {
                \Log::error('ERROR: carrera_id no existe en la BD', ['id' => $carreraId]);
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['carrera_id' => 'La carrera seleccionada no existe. Por favor, recarga la página y vuelve a intentar.']);
            }
        }
    }

    \Log::info('carrera_id FINAL después de validación:', ['carrera_id' => $carreraId]);

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
                'carrera_id' => $carreraId ?? $paciente->carrera_id,
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
                'carrera_id' => $carreraId,
                'otros_especificacion' => $request->otros_especificacion,
                'edad' => $request->edad ?? 0
            ]);
            \Log::info('Paciente creado correctamente', ['id' => $paciente->id]);
        }
    } catch (\Exception $e) {
        \Log::error('ERROR CRÍTICO en paciente:', [
            'mensaje' => $e->getMessage(),
            'linea' => $e->getLine(),
            'archivo' => $e->getFile(),
            'trace' => $e->getTraceAsString()
        ]);
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => 'Error al guardar paciente: ' . $e->getMessage()]);
    }
    
    // Crear atención (guardando snapshot de datos del paciente)
    $atencion = Atencion::create([
        'paciente_id' => $paciente->id,
        'categoria' => $request->categoria,        // Snapshot: categoría al momento de la atención
        'semestre' => $request->semestre,          // Snapshot: semestre al momento de la atención
        'grado' => $request->grado,                // Snapshot: grado al momento de la atención
        'nivel_escuela' => $request->nivel_escuela, // Snapshot: nivel escuela (INICIAL/PRIMARIA/SECUNDARIA)
        'anios' => $request->anios,                // Snapshot: años para nivel INICIAL
        'otros_especificacion' => $request->otros_especificacion, // Snapshot: especificación para categoría "Otros"
        'motivo_id' => $request->motivo_id,
        'motivo_otro' => $request->motivo_otro,
        'fecha' => $request->fecha ?? now()->format('Y-m-d'),
        'hora_entrada' => $request->hora_entrada,
        'hora_salida' => $request->hora_salida,
        'tipo_salida' => $request->tipo_salida ?? 'Manual',
        'observaciones' => $request->observaciones,
    ]);
    
    // Asociar medicamentos y descontar del stock automáticamente
    \Log::info('=== MEDICAMENTOS DEBUG ===');
    \Log::info('Request cantidad array:', $request->cantidad ?? []);
    \Log::info('Request medicamentos array:', $request->medicamentos ?? []);

    if ($request->has('cantidad') && is_array($request->cantidad)) {
        foreach ($request->cantidad as $med_id => $cantidad) {
            \Log::info("Procesando medicamento ID: {$med_id}, Cantidad: {$cantidad}");

            // Solo procesar si el checkbox está marcado Y la cantidad es mayor a 0
            if (isset($request->medicamentos[$med_id]) && $cantidad > 0) {
                // Buscar el medicamento
                $medicamento = Medicamento::find($med_id);

                \Log::info("Medicamento encontrado: " . ($medicamento ? $medicamento->nombre : 'NO ENCONTRADO'));
                \Log::info("Stock actual: " . ($medicamento ? $medicamento->cantidad_stock : 'N/A'));

                // Verificar si hay stock suficiente
                if ($medicamento && $medicamento->cantidad_stock >= $cantidad) {
                    $stockAntes = $medicamento->cantidad_stock;

                    // Descontar del stock
                    $medicamento->cantidad_stock -= $cantidad;
                    $medicamento->save();

                    $stockDespues = $medicamento->cantidad_stock;
                    \Log::info("Stock ANTES: {$stockAntes}, DESPUÉS: {$stockDespues}, DESCONTADO: {$cantidad}");

                    // Asociar a la atención
                    $atencion->medicamentos()->attach($med_id, ['cantidad_usada' => $cantidad]);
                    \Log::info("Medicamento {$med_id} asociado con cantidad_usada: {$cantidad}");
                } else {
                    // Si no hay stock suficiente, notificar
                    $nombreMed = $medicamento ? $medicamento->nombre : "ID: $med_id";
                    \Log::warning("Stock insuficiente para {$nombreMed}");
                    return redirect()->route('atenciones.index')
                        ->with('warning', "Atención registrada, pero no había stock suficiente de: {$nombreMed}. Stock disponible: " . ($medicamento ? $medicamento->cantidad_stock : 0));
                }
            } else {
                \Log::info("Medicamento {$med_id} saltado - Checkbox no marcado o cantidad 0");
            }
        }
    } else {
        \Log::info('No hay medicamentos para procesar o cantidad no es array');
    }

    return redirect()->route('atenciones.index')->with('success', 'Atención registrada correctamente y stock actualizado');
}

    public function show(string $id)
    {
        $atencion = Atencion::with(['paciente.carrera', 'motivo', 'medicamentos'])->findOrFail($id);
        return view('atenciones.show', compact('atencion'));
    }

    public function edit(string $id)
    {
        $atencion = Atencion::with(['paciente.carrera', 'motivo', 'medicamentos'])->findOrFail($id);
        $motivos = MotivoConsulta::all();
        $medicamentos = Medicamento::all();
        return view('atenciones.edit', compact('atencion', 'motivos', 'medicamentos'));
    }

    public function update(Request $request, string $id)
    {
        $atencion = Atencion::with('paciente')->findOrFail($id);

        // Determinar carrera_id según categoría
        $carreraId = null;
        if ($request->categoria === 'Otros' || $request->categoria === 'Escuela') {
            // Para "Otros" y "Escuela", carrera_id debe ser NULL
            $carreraId = null;
        } else {
            // Para Tecnológico y Pedagógico, usar el carrera_id enviado
            $carreraId = $request->carrera_id;
        }

        // Actualizar datos del paciente si existen
        if ($atencion->paciente && $request->has('dni')) {
            $atencion->paciente->update([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'edad' => $request->edad,
                'carrera_id' => $carreraId,
                'otros_especificacion' => $request->otros_especificacion
            ]);
        }

        // Actualizar atención (incluyendo snapshot de datos del paciente)
        $atencion->update([
            'categoria' => $request->categoria,
            'semestre' => $request->semestre,
            'grado' => $request->grado,
            'nivel_escuela' => $request->nivel_escuela,
            'anios' => $request->anios,
            'otros_especificacion' => $request->otros_especificacion,
            'motivo_id' => $request->motivo_id,
            'motivo_otro' => $request->motivo_otro,
            'fecha' => $request->fecha,
            'hora_entrada' => $request->hora_entrada,
            'hora_salida' => $request->hora_salida,
            'tipo_salida' => $request->tipo_salida,
            'observaciones' => $request->observaciones,
        ]);

        // Actualizar medicamentos si existen
        \Log::info('=== UPDATE MEDICAMENTOS DEBUG ===');

        if ($request->has('cantidad')) {
            // PASO 1: Devolver al stock los medicamentos antiguos
            $medicamentosAntiguos = $atencion->medicamentos;
            \Log::info('Devolviendo ' . $medicamentosAntiguos->count() . ' medicamentos antiguos al stock');

            foreach ($medicamentosAntiguos as $medAntiguo) {
                $medicamento = Medicamento::find($medAntiguo->id);
                if ($medicamento) {
                    // Devolver la cantidad que se había usado
                    $cantidadAntigua = $medAntiguo->pivot->cantidad_usada;
                    $stockAntes = $medicamento->cantidad_stock;
                    $medicamento->cantidad_stock += $cantidadAntigua;
                    $medicamento->save();
                    \Log::info("Devuelto: {$medicamento->nombre} - Stock antes: {$stockAntes}, devuelto: {$cantidadAntigua}, después: {$medicamento->cantidad_stock}");
                }
            }

            // PASO 2: Limpiar relaciones antiguas
            $atencion->medicamentos()->detach();
            \Log::info('Relaciones antiguas limpiadas');

            // PASO 3: Asociar nuevos medicamentos y descontar del stock
            \Log::info('Procesando nuevos medicamentos:', $request->cantidad ?? []);

            foreach ($request->cantidad as $med_id => $cantidad) {
                \Log::info("Update - Procesando medicamento ID: {$med_id}, Cantidad: {$cantidad}");

                // Solo procesar si el checkbox está marcado Y la cantidad es mayor a 0
                if (isset($request->medicamentos[$med_id]) && $cantidad > 0) {
                    $medicamento = Medicamento::find($med_id);

                    \Log::info("Medicamento encontrado: " . ($medicamento ? $medicamento->nombre : 'NO ENCONTRADO'));

                    // Verificar si hay stock suficiente
                    if ($medicamento && $medicamento->cantidad_stock >= $cantidad) {
                        $stockAntes = $medicamento->cantidad_stock;

                        // Descontar del stock
                        $medicamento->cantidad_stock -= $cantidad;
                        $medicamento->save();

                        $stockDespues = $medicamento->cantidad_stock;
                        \Log::info("Update - Stock ANTES: {$stockAntes}, DESPUÉS: {$stockDespues}, DESCONTADO: {$cantidad}");

                        // Asociar a la atención
                        $atencion->medicamentos()->attach($med_id, ['cantidad_usada' => $cantidad]);
                    } else {
                        // Si no hay stock suficiente, notificar
                        $nombreMed = $medicamento ? $medicamento->nombre : "ID: $med_id";
                        \Log::warning("Update - Stock insuficiente para {$nombreMed}");
                        return redirect()->route('atenciones.index')
                            ->with('warning', "Atención actualizada, pero no había stock suficiente de: {$nombreMed}. Stock disponible: " . ($medicamento ? $medicamento->cantidad_stock : 0));
                    }
                } else {
                    \Log::info("Update - Medicamento {$med_id} saltado");
                }
            }
        }

        return redirect()->route('atenciones.index')->with('success', 'Atención actualizada correctamente y stock ajustado');
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
        $atencion = Atencion::with('medicamentos')->find($id);

        // Devolver medicamentos al stock antes de eliminar
        foreach ($atencion->medicamentos as $medicamento) {
            $med = Medicamento::find($medicamento->id);
            if ($med) {
                // Devolver la cantidad que se había usado
                $cantidadUsada = $medicamento->pivot->cantidad_usada;
                $med->cantidad_stock += $cantidadUsada;
                $med->save();
            }
        }

        // Eliminar relaciones y atención
        $atencion->medicamentos()->detach();
        $atencion->delete();

        return redirect()->route('atenciones.index')->with('success', 'Atención eliminada y stock devuelto correctamente');
    }
}