@extends('layouts.app')

@section('page_title', 'Detalle de Atención')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Información de la Atención</h2>
        <a href="{{ route('atenciones.index') }}" class="btn btn-secondary float-right">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Información del Paciente -->
            <div class="col-md-6">
                <h4><i class="fas fa-user"></i> Datos del Paciente</h4>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">DNI:</th>
                        <td><strong>{{ $atencion->paciente->dni ?? 'N/A' }}</strong></td>
                    </tr>
                    <tr>
                        <th>Nombre Completo:</th>
                        <td>
                            @if($atencion->paciente)
                                {{ $atencion->paciente->nombre }} {{ $atencion->paciente->apellido }}
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Edad:</th>
                        <td>{{ $atencion->paciente->edad ?? 'N/A' }} años</td>
                    </tr>
                    <tr>
                        <th>Carrera/Área:</th>
                        <td>
                            @if($atencion->paciente && $atencion->paciente->carrera)
                                <span class="badge badge-info">{{ $atencion->paciente->carrera->acronimo }}</span>
                                {{ $atencion->paciente->carrera->nombre }}
                            @else
                                {{ $atencion->paciente->otros_especificacion ?? 'N/A' }}
                            @endif
                        </td>
                    </tr>
                </table>

                @if($atencion->paciente)
                    <a href="{{ route('pacientes.show', $atencion->paciente) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-user"></i> Ver Perfil del Paciente
                    </a>
                @endif
            </div>

            <!-- Información de la Atención -->
            <div class="col-md-6">
                <h4><i class="fas fa-file-medical"></i> Datos de la Atención</h4>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Fecha:</th>
                        <td>{{ $atencion->fecha ? \Carbon\Carbon::parse($atencion->fecha)->format('d/m/Y') : $atencion->created_at->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Hora de Entrada:</th>
                        <td><strong>{{ $atencion->hora_entrada }}</strong></td>
                    </tr>
                    <tr>
                        <th>Hora de Salida:</th>
                        <td>
                            @if($atencion->hora_salida)
                                <strong>{{ $atencion->hora_salida }}</strong>
                            @else
                                <span class="badge badge-warning">En atención</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tipo de Salida:</th>
                        <td>
                            <span class="badge badge-{{ $atencion->tipo_salida == 'Automática' ? 'success' : 'info' }}">
                                {{ $atencion->tipo_salida ?? 'Manual' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Motivo de Consulta:</th>
                        <td>
                            @if($atencion->motivo)
                                <strong>{{ $atencion->motivo->nombre }}</strong>
                            @else
                                {{ $atencion->motivo_otro }}
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <!-- Medicamentos Usados -->
        <h4><i class="fas fa-pills"></i> Medicamentos Usados</h4>

        @if($atencion->medicamentos->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Medicamento</th>
                            <th>Descripción</th>
                            <th>Cantidad Usada</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($atencion->medicamentos as $medicamento)
                            <tr>
                                <td><strong>{{ $medicamento->nombre }}</strong></td>
                                <td>{{ $medicamento->descripcion ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge badge-primary">{{ $medicamento->pivot->cantidad_usada ?? 0 }} unidades</span>
                                </td>
                                <td>{{ $medicamento->pivot->observaciones ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No se usaron medicamentos en esta atención.
            </div>
        @endif

        <hr>

        <!-- Observaciones -->
        @if($atencion->observaciones)
            <h4><i class="fas fa-clipboard"></i> Observaciones</h4>
            <div class="alert alert-secondary">
                {{ $atencion->observaciones }}
            </div>
        @endif

        <!-- Botones de Acción -->
        <div class="mt-4">
            <a href="{{ route('atenciones.edit', $atencion) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar Atención
            </a>
            <a href="{{ route('atenciones.index') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i> Ver Todas las Atenciones
            </a>
        </div>
    </div>
</div>
@endsection
