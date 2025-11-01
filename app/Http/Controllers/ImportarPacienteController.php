<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ImportarPacienteController extends Controller
{
    /**
     * Mostrar formulario de importación
     */
    public function index()
    {
        return view('pacientes.importar');
    }

    /**
     * Procesar archivo de importación
     */
    public function importar(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        try {
            $archivo = $request->file('archivo');
            $contenido = file_get_contents($archivo->getRealPath());

            // Detectar y convertir a UTF-8 si es necesario
            if (!mb_check_encoding($contenido, 'UTF-8')) {
                $contenido = mb_convert_encoding($contenido, 'UTF-8', 'ISO-8859-1');
            }

            $lineas = array_map('str_getcsv', explode("\n", $contenido));

            // Remover encabezados
            $encabezados = array_shift($lineas);

            $importados = 0;
            $errores = [];
            $duplicados = 0;

            DB::beginTransaction();

            foreach ($lineas as $index => $linea) {
                // Saltar líneas vacías
                if (empty($linea) || count($linea) < 5) {
                    continue;
                }

                $numeroLinea = $index + 2; // +2 porque array inicia en 0 y hay encabezado

                $datos = [
                    'dni' => trim($linea[0] ?? ''),
                    'nombre' => trim($linea[1] ?? ''),
                    'apellido' => trim($linea[2] ?? ''),
                    'edad' => trim($linea[3] ?? ''),
                    'categoria' => trim($linea[4] ?? ''),
                    'nombre_carrera' => trim($linea[5] ?? ''),
                    'otros_especificacion' => trim($linea[6] ?? ''),
                ];

                // Validar datos
                $validator = Validator::make($datos, [
                    'dni' => 'required|digits:8',
                    'nombre' => 'required|string|max:255',
                    'apellido' => 'required|string|max:255',
                    'edad' => 'required|integer|min:1|max:120',
                    'categoria' => 'required|in:Secundaria,Tecnológico,Técnico,Universitario,Personal,Otros',
                ]);

                if ($validator->fails()) {
                    $errores[] = "Línea {$numeroLinea}: " . implode(', ', $validator->errors()->all());
                    continue;
                }

                // Verificar si el paciente ya existe
                $pacienteExistente = Paciente::where('dni', $datos['dni'])->first();
                if ($pacienteExistente) {
                    $duplicados++;
                    continue;
                }

                // Buscar o crear carrera
                $carrera_id = null;
                if (!empty($datos['nombre_carrera']) && $datos['categoria'] !== 'Otros') {
                    $carrera = Carrera::where('nombre', $datos['nombre_carrera'])
                                      ->where('categoria', $datos['categoria'])
                                      ->first();

                    if (!$carrera) {
                        $carrera = Carrera::create([
                            'nombre' => $datos['nombre_carrera'],
                            'categoria' => $datos['categoria'],
                        ]);
                    }

                    $carrera_id = $carrera->id;
                }

                // Crear paciente
                Paciente::create([
                    'dni' => $datos['dni'],
                    'nombre' => $datos['nombre'],
                    'apellido' => $datos['apellido'],
                    'edad' => $datos['edad'],
                    'carrera_id' => $carrera_id,
                    'otros_especificacion' => $datos['otros_especificacion'],
                ]);

                $importados++;
            }

            DB::commit();

            $mensaje = "✅ Importación completada: {$importados} paciente(s) importado(s).";
            if ($duplicados > 0) {
                $mensaje .= " {$duplicados} paciente(s) omitido(s) por DNI duplicado.";
            }
            if (count($errores) > 0) {
                $mensaje .= " " . count($errores) . " error(es) encontrado(s).";
            }

            return redirect()->route('pacientes.importar')
                           ->with('success', $mensaje)
                           ->with('errores', $errores);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pacientes.importar')
                           ->with('error', 'Error al procesar el archivo: ' . $e->getMessage());
        }
    }

    /**
     * Descargar plantilla de ejemplo
     */
    public function descargarPlantilla()
    {
        $contenido = "DNI,Nombre,Apellido,Edad,Categoría,Nombre de Carrera/Programa,Otros (Especificar)\n";
        $contenido .= "12345678,Juan,Pérez García,18,Secundaria,5to Año Secundaria,\n";
        $contenido .= "87654321,María,López Ruiz,20,Tecnológico,Computación e Informática,\n";
        $contenido .= "11223344,Pedro,Quispe Mamani,19,Técnico,Enfermería Técnica,\n";
        $contenido .= "44332211,Ana,Huamán Flores,22,Universitario,Administración de Empresas,\n";
        $contenido .= "55667788,Carlos,Torres Mendoza,35,Personal,Personal Administrativo,\n";
        $contenido .= "99887766,Luis,Vargas Díaz,25,Otros,,Visitante\n";

        $nombreArchivo = 'plantilla_importacion_pacientes_' . date('Y-m-d') . '.csv';

        return response($contenido, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $nombreArchivo . '"',
            'Content-Length' => strlen($contenido),
        ]);
    }
}
