@extends('layouts.app')

@section('page_title', 'Reportes - Enfermedades Comunes')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Enfermedades y Motivos de Consulta Más Comunes</h3>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('reportes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('reportes.enfermedad.pdf') }}" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> Descargar PDF
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Motivo de Consulta / Enfermedad</th>
                    <th>Total de Casos</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalGeneral = $enfermedades->sum();
                @endphp
                @forelse($enfermedades as $enfermedad => $total)
                    <tr>
                        <td><strong>{{ $enfermedad }}</strong></td>
                        <td><span class="badge badge-danger badge-lg">{{ $total }}</span></td>
                        <td>{{ $totalGeneral > 0 ? number_format(($total / $totalGeneral) * 100, 1) : 0 }}%</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No hay datos disponibles</td>
                    </tr>
                @endforelse
                @if($totalGeneral > 0)
                    <tr style="background: #f0f0f0; font-weight: bold;">
                        <td>TOTAL</td>
                        <td><span class="badge badge-success badge-lg">{{ $totalGeneral }}</span></td>
                        <td>100%</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection