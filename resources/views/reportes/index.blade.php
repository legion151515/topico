@extends('layouts.app')

@section('page_title', 'Reportes')

@section('content')
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="card" style="text-align: center; padding: 30px;">
        <i class="fas fa-chart-pie" style="font-size: 40px; color: #4CAF50; margin-bottom: 15px;"></i>
        <h3 style="color: #1e3c72; margin: 15px 0;">Atenciones por Área</h3>
        <p>Estadísticas de pacientes por carrera</p>
        <a href="{{ route('reportes.area') }}" class="btn btn-primary" style="margin-top: 15px;">
            Ver Reporte
        </a>
    </div>

    <div class="card" style="text-align: center; padding: 30px;">
        <i class="fas fa-hospital-user" style="font-size: 40px; color: #3498db; margin-bottom: 15px;"></i>
        <h3 style="color: #1e3c72; margin: 15px 0;">Enfermedades Comunes</h3>
        <p>Motivos de consulta más frecuentes</p>
        <a href="{{ route('reportes.enfermedad') }}" class="btn btn-primary" style="margin-top: 15px;">
            Ver Reporte
        </a>
    </div>

    <div class="card" style="text-align: center; padding: 30px;">
        <i class="fas fa-exclamation-triangle" style="font-size: 40px; color: #e74c3c; margin-bottom: 15px;"></i>
        <h3 style="color: #1e3c72; margin: 15px 0;">Stock Bajo</h3>
        <p>Medicamentos con inventario bajo</p>
        <a href="{{ route('reportes.stock') }}" class="btn btn-primary" style="margin-top: 15px;">
            Ver Reporte
        </a>
    </div>
</div>
@endsection