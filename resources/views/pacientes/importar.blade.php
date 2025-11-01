@extends('layouts.app')

@section('page_title', 'Importar Pacientes')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-file-import"></i> Importar Pacientes desde Excel/CSV</h3>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('pacientes.plantilla') }}" class="btn btn-success">
                <i class="fas fa-download"></i> Descargar Plantilla
            </a>
        </div>
    </div>

    <div class="card-body">
        {{-- Mensajes de éxito/error --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('errores') && count(session('errores')) > 0)
            <div class="alert alert-warning">
                <h5><i class="fas fa-exclamation-triangle"></i> Errores encontrados:</h5>
                <ul style="margin-bottom: 0; padding-left: 20px;">
                    @foreach(session('errores') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Instrucciones --}}
        <div class="alert alert-info">
            <h4 class="alert-heading"><i class="fas fa-info-circle"></i> Instrucciones para Importar</h4>
            <hr>
            <ol style="margin-bottom: 0;">
                <li><strong>Descarga la plantilla</strong> haciendo clic en el botón "Descargar Plantilla"</li>
                <li><strong>Abre el archivo</strong> con Microsoft Excel, Google Sheets o LibreOffice Calc</li>
                <li><strong>Completa los datos</strong> de los pacientes siguiendo el formato de ejemplo</li>
                <li><strong>Guarda el archivo</strong> en formato CSV (separado por comas)</li>
                <li><strong>Sube el archivo</strong> usando el formulario de abajo</li>
            </ol>
        </div>

        {{-- Información de los campos --}}
        <div class="card mb-4" style="background: #f8f9fa;">
            <div class="card-body">
                <h5><i class="fas fa-table"></i> Formato del Archivo CSV</h5>
                <p>El archivo debe contener las siguientes columnas en este orden:</p>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>Columna</th>
                                <th>Descripción</th>
                                <th>Ejemplo</th>
                                <th>Obligatorio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>DNI</strong></td>
                                <td>Documento Nacional de Identidad (8 dígitos)</td>
                                <td>12345678</td>
                                <td><span class="badge badge-danger">Sí</span></td>
                            </tr>
                            <tr>
                                <td><strong>Nombre</strong></td>
                                <td>Nombre(s) del paciente</td>
                                <td>Juan Carlos</td>
                                <td><span class="badge badge-danger">Sí</span></td>
                            </tr>
                            <tr>
                                <td><strong>Apellido</strong></td>
                                <td>Apellido(s) del paciente</td>
                                <td>Pérez García</td>
                                <td><span class="badge badge-danger">Sí</span></td>
                            </tr>
                            <tr>
                                <td><strong>Edad</strong></td>
                                <td>Edad del paciente (número entero)</td>
                                <td>18</td>
                                <td><span class="badge badge-danger">Sí</span></td>
                            </tr>
                            <tr>
                                <td><strong>Categoría</strong></td>
                                <td>
                                    Debe ser uno de: <br>
                                    <code>Secundaria</code>, <code>Tecnológico</code>, <code>Técnico</code>,
                                    <code>Universitario</code>, <code>Personal</code>, <code>Otros</code>
                                </td>
                                <td>Secundaria</td>
                                <td><span class="badge badge-danger">Sí</span></td>
                            </tr>
                            <tr>
                                <td><strong>Nombre de Carrera/Programa</strong></td>
                                <td>Nombre del programa o carrera (dejar vacío si es "Otros")</td>
                                <td>5to Año Secundaria<br>Computación e Informática</td>
                                <td><span class="badge badge-warning">No</span></td>
                            </tr>
                            <tr>
                                <td><strong>Otros (Especificar)</strong></td>
                                <td>Especificación adicional si categoría es "Otros"</td>
                                <td>Visitante<br>Padre de familia</td>
                                <td><span class="badge badge-warning">No</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Formulario de carga --}}
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-upload"></i> Subir Archivo CSV</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pacientes.importar.procesar') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="archivo">
                            <i class="fas fa-file-csv"></i> Selecciona el archivo CSV:
                        </label>
                        <div class="custom-file">
                            <input
                                type="file"
                                class="custom-file-input @error('archivo') is-invalid @enderror"
                                id="archivo"
                                name="archivo"
                                accept=".csv,.txt"
                                required
                                onchange="updateFileName(this)"
                            >
                            <label class="custom-file-label" for="archivo" id="archivo-label">
                                Elegir archivo...
                            </label>
                            @error('archivo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i>
                            Archivos permitidos: .csv, .txt | Tamaño máximo: 2 MB
                        </small>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Importante:</strong>
                        <ul style="margin-bottom: 0; margin-top: 10px;">
                            <li>Los pacientes con DNI duplicado serán omitidos automáticamente</li>
                            <li>Las carreras/programas nuevos se crearán automáticamente</li>
                            <li>Verifica que los datos sean correctos antes de importar</li>
                        </ul>
                    </div>

                    <div class="form-group text-center" style="margin-top: 25px;">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-file-import"></i> Importar Pacientes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tips adicionales --}}
        <div class="card mt-4" style="border-left: 4px solid #17a2b8;">
            <div class="card-body">
                <h5><i class="fas fa-lightbulb"></i> Consejos</h5>
                <ul style="margin-bottom: 0;">
                    <li>Asegúrate de que el archivo esté guardado con codificación UTF-8 para evitar problemas con caracteres especiales (tildes, ñ, etc.)</li>
                    <li>No modifiques los encabezados de la plantilla (primera fila)</li>
                    <li>Puedes importar desde 1 hasta cientos de pacientes en un solo archivo</li>
                    <li>Si tienes errores, revisa el mensaje de error para identificar qué líneas tienen problemas</li>
                    <li>En Excel, usa "Guardar como" → "CSV (delimitado por comas)"</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function updateFileName(input) {
    const label = document.getElementById('archivo-label');
    const fileName = input.files[0]?.name || 'Elegir archivo...';
    label.textContent = fileName;
}
</script>

<style>
.alert-heading {
    margin-bottom: 10px;
}

.custom-file-label::after {
    content: "Buscar";
}

.table-sm th, .table-sm td {
    padding: 8px;
    vertical-align: middle;
}

code {
    background-color: #f8f9fa;
    padding: 2px 6px;
    border-radius: 3px;
    color: #e83e8c;
}
</style>
@endsection
