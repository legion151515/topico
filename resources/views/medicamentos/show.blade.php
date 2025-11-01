@extends('layouts.app')

@section('page_title', 'Detalle del Medicamento')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Información del Medicamento</h2>
        <a href="{{ route('medicamentos.index') }}" class="btn btn-secondary float-right">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Nombre:</th>
                        <td><strong>{{ $medicamento->nombre }}</strong></td>
                    </tr>
                    <tr>
                        <th>Descripción:</th>
                        <td>{{ $medicamento->descripcion ?? 'No especificada' }}</td>
                    </tr>
                    <tr>
                        <th>Cantidad en Stock:</th>
                        <td>
                            <span class="badge badge-{{ $medicamento->cantidad_stock < $medicamento->stock_minimo_alerta ? 'danger' : 'success' }} badge-lg">
                                {{ $medicamento->cantidad_stock }} unidades
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Stock Mínimo:</th>
                        <td>{{ $medicamento->stock_minimo_alerta }} unidades</td>
                    </tr>
                    <tr>
                        <th>Fecha de Vencimiento:</th>
                        <td>
                            @if($medicamento->fecha_vencimiento)
                                {{ \Carbon\Carbon::parse($medicamento->fecha_vencimiento)->format('d/m/Y') }}
                                @if(\Carbon\Carbon::parse($medicamento->fecha_vencimiento)->isPast())
                                    <span class="badge badge-danger">Vencido</span>
                                @elseif(\Carbon\Carbon::parse($medicamento->fecha_vencimiento)->diffInDays(now()) < 30)
                                    <span class="badge badge-warning">Próximo a vencer</span>
                                @endif
                            @else
                                <span class="text-muted">No especificada</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Fecha de Registro:</th>
                        <td>{{ $medicamento->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>

                <div class="mt-3">
                    <a href="{{ route('medicamentos.edit', $medicamento) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                </div>
            </div>

            <div class="col-md-6">
                <h4>Resumen de Uso</h4>
                <div class="card bg-light">
                    <div class="card-body">
                        <h3 class="text-center">{{ $medicamento->atenciones->count() }}</h3>
                        <p class="text-center mb-0">Veces Utilizado</p>
                    </div>
                </div>

                @if($medicamento->cantidad_stock < $medicamento->stock_minimo_alerta)
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Alerta:</strong> El stock está por debajo del mínimo establecido.
                        Se recomienda reabastecer.
                    </div>
                @endif
            </div>
        </div>

        <hr>

        <h4>Historial de Uso en Atenciones</h4>

        @if($medicamento->atenciones->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Paciente</th>
                            <th>DNI</th>
                            <th>Cantidad Usada</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medicamento->atenciones->sortByDesc('created_at') as $atencion)
                            <tr>
                                <td>{{ $atencion->fecha ?? $atencion->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @if($atencion->paciente)
                                        {{ $atencion->paciente->nombre }} {{ $atencion->paciente->apellido }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($atencion->paciente)
                                        {{ $atencion->paciente->dni }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $atencion->pivot->cantidad_usada ?? 0 }}</strong> unidades
                                </td>
                                <td>{{ $atencion->pivot->observaciones ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                Este medicamento no ha sido utilizado en ninguna atención aún.
            </div>
        @endif
    </div>
</div>
@endsection
