@extends('layouts.app')

@section('page_title', 'Reportes - Stock Bajo')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Medicamentos con Stock Bajo</h3>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('reportes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('reportes.stock.pdf') }}" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> Descargar PDF
            </a>
        </div>
    </div>
    <div class="card-body">
        @if($medicamentos->count() > 0)
            <div class="alert alert-warning" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Alerta:</strong> Se encontraron {{ $medicamentos->count() }} medicamento(s) con stock por debajo del mínimo establecido.
            </div>
        @else
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle"></i>
                <strong>Todo en orden:</strong> No hay medicamentos con stock bajo.
            </div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Medicamento</th>
                    <th>Stock Actual</th>
                    <th>Stock Mínimo</th>
                    <th>Diferencia</th>
                    <th>Fecha Vencimiento</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($medicamentos as $medicamento)
                    @php
                        $diferencia = $medicamento->cantidad_stock - $medicamento->stock_minimo_alerta;
                        $diasParaVencer = null;
                        if ($medicamento->fecha_vencimiento) {
                            $diasParaVencer = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($medicamento->fecha_vencimiento), false);
                        }
                    @endphp
                    <tr class="{{ $diasParaVencer !== null && $diasParaVencer < 0 ? 'table-danger' : ($diasParaVencer !== null && $diasParaVencer <= 30 ? 'table-warning' : '') }}">
                        <td><strong>{{ $medicamento->nombre }}</strong></td>
                        <td>
                            <span class="badge {{ $medicamento->cantidad_stock == 0 ? 'badge-danger' : 'badge-warning' }} badge-lg">
                                {{ $medicamento->cantidad_stock }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-info badge-lg">{{ $medicamento->stock_minimo_alerta }}</span>
                        </td>
                        <td>
                            <strong style="color: {{ $diferencia < 0 ? '#f44336' : '#ff9800' }};">
                                {{ $diferencia }}
                            </strong>
                        </td>
                        <td>
                            @if($medicamento->fecha_vencimiento)
                                {{ \Carbon\Carbon::parse($medicamento->fecha_vencimiento)->format('d/m/Y') }}
                                @if($diasParaVencer !== null)
                                    <br>
                                    <small class="text-muted">
                                        @if($diasParaVencer < 0)
                                            <span class="badge badge-danger">Vencido</span>
                                        @elseif($diasParaVencer == 0)
                                            <span class="badge badge-danger">Vence hoy</span>
                                        @elseif($diasParaVencer <= 30)
                                            <span class="badge badge-warning">{{ $diasParaVencer }} días</span>
                                        @else
                                            {{ $diasParaVencer }} días
                                        @endif
                                    </small>
                                @endif
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            @if($medicamento->cantidad_stock == 0)
                                <span class="badge badge-danger">SIN STOCK</span>
                            @else
                                <span class="badge badge-warning">STOCK BAJO</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            <i class="fas fa-check-circle text-success"></i>
                            No hay medicamentos con stock bajo
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection