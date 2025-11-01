@extends('layouts.app')

@section('page_title', 'Historial Clínico')

@section('content')
<div class="card">
    <div class="card-header">
        <h2><i class="fas fa-file-medical-alt"></i> Historial Clínico del Paciente</h2>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('historial.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Nueva Búsqueda
            </a>
            <a href="{{ route('historial.pdf', $paciente->id) }}" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> Generar PDF
            </a>
        </div>
    </div>

    <div class="card-body">
        <!-- DATOS DEL PACIENTE -->
        <div class="card bg-light" style="margin-bottom: 30px;">
            <div class="card-body">
                <h3><i class="fas fa-user"></i> Información del Paciente</h3>
                <div class="row">
                    <div class="col-md-3">
                        <strong>DNI:</strong>
                        <p style="font-size: 20px; color: #1e3c72; margin: 5px 0;">{{ $paciente->dni }}</p>
                    </div>
                    <div class="col-md-3">
                        <strong>Nombre Completo:</strong>
                        <p style="font-size: 16px; margin: 5px 0;">{{ $paciente->nombre }} {{ $paciente->apellido }}</p>
                    </div>
                    <div class="col-md-2">
                        <strong>Edad:</strong>
                        <p style="font-size: 16px; margin: 5px 0;">{{ $paciente->edad }} años</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Carrera/Área:</strong>
                        <p style="font-size: 16px; margin: 5px 0;">
                            @if($paciente->carrera)
                                <span class="badge badge-info">{{ $paciente->carrera->acronimo }}</span>
                                {{ $paciente->carrera->nombre }}
                            @else
                                {{ $paciente->otros_especificacion ?? 'No especificado' }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- RESUMEN DE ATENCIONES -->
        <div class="row" style="margin-bottom: 30px;">
            <div class="col-md-4">
                <div class="card text-center" style="border-left: 4px solid #4CAF50;">
                    <div class="card-body">
                        <div style="font-size: 40px; font-weight: bold; color: #4CAF50;">
                            {{ $paciente->atenciones->count() }}
                        </div>
                        <p style="color: #666; margin-top: 10px;">Total de Atenciones</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center" style="border-left: 4px solid #2196F3;">
                    <div class="card-body">
                        <div style="font-size: 40px; font-weight: bold; color: #2196F3;">
                            {{ $paciente->atenciones->where('created_at', '>=', now()->subDays(30))->count() }}
                        </div>
                        <p style="color: #666; margin-top: 10px;">Últimos 30 días</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center" style="border-left: 4px solid #FF9800;">
                    <div class="card-body">
                        <div style="font-size: 40px; font-weight: bold; color: #FF9800;">
                            {{ $paciente->atenciones->first() ? $paciente->atenciones->first()->created_at->format('d/m/Y') : 'N/A' }}
                        </div>
                        <p style="color: #666; margin-top: 10px;">Primera Atención</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- HISTORIAL DE ATENCIONES -->
        <h3 style="margin-bottom: 20px;"><i class="fas fa-history"></i> Historial de Atenciones</h3>

        @if($paciente->atenciones->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead style="background: #1e3c72; color: white;">
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Hora Entrada</th>
                            <th>Hora Salida</th>
                            <th>Motivo de Consulta</th>
                            <th>Medicamentos</th>
                            <th>Observaciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paciente->atenciones->sortByDesc('created_at') as $index => $atencion)
                            <tr>
                                <td><strong>{{ $index + 1 }}</strong></td>
                                <td>
                                    <strong>{{ $atencion->fecha ? \Carbon\Carbon::parse($atencion->fecha)->format('d/m/Y') : $atencion->created_at->format('d/m/Y') }}</strong>
                                </td>
                                <td>{{ $atencion->hora_entrada }}</td>
                                <td>
                                    @if($atencion->hora_salida)
                                        {{ $atencion->hora_salida }}
                                    @else
                                        <span class="badge badge-warning">En atención</span>
                                    @endif
                                </td>
                                <td>
                                    @if($atencion->motivo)
                                        <span class="badge badge-info">{{ $atencion->motivo->nombre }}</span>
                                    @else
                                        {{ $atencion->motivo_otro }}
                                    @endif
                                </td>
                                <td>
                                    @if($atencion->medicamentos->count() > 0)
                                        <ul style="margin: 0; padding-left: 20px; font-size: 13px;">
                                            @foreach($atencion->medicamentos as $med)
                                                <li>
                                                    <strong>{{ $med->nombre }}</strong>
                                                    @if($med->pivot->cantidad_usada)
                                                        ({{ $med->pivot->cantidad_usada }} unidades)
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">Sin medicamentos</span>
                                    @endif
                                </td>
                                <td>
                                    @if($atencion->observaciones)
                                        <span style="font-size: 13px;">{{ Str::limit($atencion->observaciones, 50) }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('atenciones.show', $atencion->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Este paciente no tiene atenciones registradas aún.
            </div>
        @endif

        <!-- PIE DE PÁGINA -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #e0e0e0; text-align: center; color: #666;">
            <p><strong>Tópico La Salle Urubamba</strong></p>
            <p style="font-size: 13px;">Historial generado el {{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</div>

<style>
    @media print {
        .btn, .card-header .btn {
            display: none;
        }
    }
</style>
@endsection
