@extends('layouts.app')

@section('page_title', 'Dashboard')

@section('content')

<!-- FUNCIONES RÁPIDAS -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
    
    <!-- Pacientes Hoy -->
    <div class="card" style="text-align: center; border-left: 4px solid #4CAF50;">
        <div style="font-size: 40px; font-weight: bold; color: #4CAF50;">{{ $pacientes_hoy }}</div>
        <p style="color: #666; margin-top: 10px;">Pacientes Hoy</p>
        <a href="{{ route('atenciones.index') }}" class="btn btn-primary" style="margin-top: 15px;">Ver</a>
    </div>

    <!-- Medicamentos a Vencer -->
    <div class="card" style="text-align: center; border-left: 4px solid #ff9800;">
        <div style="font-size: 40px; font-weight: bold; color: #ff9800;">{{ $medicamentos_vencer }}</div>
        <p style="color: #666; margin-top: 10px;">Medicamentos a Vencer</p>
        <a href="{{ route('medicamentos.index') }}" class="btn btn-warning" style="margin-top: 15px;">Ver</a>
    </div>

    <!-- Nueva Atención -->
    <div class="card" style="text-align: center; border-left: 4px solid #2196F3;">
        <div style="font-size: 40px; font-weight: bold; color: #2196F3;">+</div>
        <p style="color: #666; margin-top: 10px;">Nueva Atención</p>
        <a href="{{ route('atenciones.create') }}" class="btn btn-info" style="margin-top: 15px;">Crear</a>
    </div>

    <!-- Reportes -->
    <div class="card" style="text-align: center; border-left: 4px solid #9C27B0;">
        <div style="font-size: 40px; font-weight: bold; color: #9C27B0;">📊</div>
        <p style="color: #666; margin-top: 10px;">Reportes</p>
        <a href="{{ route('reportes.index') }}" class="btn btn-secondary" style="margin-top: 15px;">Ver</a>
    </div>

</div>

<!-- ÚLTIMAS 5 ATENCIONES -->
<div class="card">
    <div class="card-header">
        <h2>ÚLTIMAS 5 ATENCIONES</h2>
    </div>
    <div style="overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Paciente</th>
                    <th>Acrónimo</th>
                    <th>Motivo</th>
                    <th>Hora</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ultimas_atenciones as $atencion)
                    <tr>
                        <td>{{ $atencion->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if($atencion->paciente)
                                {{ $atencion->paciente->nombre }} {{ $atencion->paciente->apellido }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($atencion->paciente && $atencion->paciente->carrera && $atencion->paciente->carrera->acronimo)
                                <span class="badge badge-secondary">{{ $atencion->paciente->carrera->acronimo }}</span>
                            @elseif($atencion->categoria)
                                <span class="badge badge-info">{{ $atencion->categoria }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $atencion->motivo->nombre ?? $atencion->motivo_otro ?? 'N/A' }}</td>
                        <td>{{ $atencion->hora_entrada }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">No hay atenciones registradas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection