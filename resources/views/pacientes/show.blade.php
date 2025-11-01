@extends('layouts.app')

@section('page_title', 'Detalle del Paciente')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Información del Paciente</h2>
        <a href="{{ route('pacientes.index') }}" class="btn btn-secondary float-right">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">DNI:</th>
                        <td><strong>{{ $paciente->dni }}</strong></td>
                    </tr>
                    <tr>
                        <th>Nombre Completo:</th>
                        <td>{{ $paciente->nombre }} {{ $paciente->apellido }}</td>
                    </tr>
                    <tr>
                        <th>Edad:</th>
                        <td>{{ $paciente->edad }} años</td>
                    </tr>
                    <tr>
                        <th>Carrera/Área:</th>
                        <td>
                            @if($paciente->carrera)
                                <span class="badge badge-info">{{ $paciente->carrera->acronimo }}</span>
                                {{ $paciente->carrera->nombre }}
                            @else
                                <span class="badge badge-secondary">{{ $paciente->otros_especificacion ?? 'No especificado' }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Fecha de Registro:</th>
                        <td>{{ $paciente->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>

                <div class="mt-3">
                    <a href="{{ route('pacientes.edit', $paciente) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                </div>
            </div>

            <div class="col-md-6">
                <h4>Resumen de Atenciones</h4>
                <div class="card bg-light">
                    <div class="card-body">
                        <h3 class="text-center">{{ $paciente->atenciones->count() }}</h3>
                        <p class="text-center mb-0">Total de Atenciones</p>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <h4>Historial de Atenciones</h4>

        @if($paciente->atenciones->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora Entrada</th>
                            <th>Hora Salida</th>
                            <th>Motivo</th>
                            <th>Medicamentos</th>
                            <th>Tipo Salida</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paciente->atenciones->sortByDesc('created_at') as $atencion)
                            <tr>
                                <td>{{ $atencion->fecha ?? $atencion->created_at->format('Y-m-d') }}</td>
                                <td>{{ $atencion->hora_entrada }}</td>
                                <td>{{ $atencion->hora_salida ?? 'En atención' }}</td>
                                <td>
                                    @if($atencion->motivo)
                                        {{ $atencion->motivo->nombre }}
                                    @else
                                        {{ $atencion->motivo_otro }}
                                    @endif
                                </td>
                                <td>
                                    @if($atencion->medicamentos->count() > 0)
                                        <ul class="mb-0 pl-3">
                                            @foreach($atencion->medicamentos as $med)
                                                <li>{{ $med->nombre }} ({{ $med->pivot->cantidad_usada ?? 0 }})</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">Sin medicamentos</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $atencion->tipo_salida == 'Automática' ? 'success' : 'info' }}">
                                        {{ $atencion->tipo_salida ?? 'Manual' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                Este paciente no tiene atenciones registradas aún.
            </div>
        @endif
    </div>
</div>
@endsection
