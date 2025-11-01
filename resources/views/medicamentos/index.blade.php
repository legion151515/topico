@extends('layouts.app')

@section('page_title', 'Gestión de Medicamentos')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Medicamentos en Stock</h2>
        <a href="{{ route('medicamentos.create') }}" class="btn btn-primary float-right">
            <i class="fas fa-plus"></i> Nuevo Medicamento
        </a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Stock Actual</th>
                    <th>Stock Mínimo</th>
                    <th>Fecha Vencimiento</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($medicamentos as $medicamento)
                    <tr class="{{ $medicamento->cantidad_stock < $medicamento->stock_minimo_alerta ? 'table-warning' : '' }}">
                        <td><strong>{{ $medicamento->nombre }}</strong></td>
                        <td>{{ $medicamento->descripcion ?? 'N/A' }}</td>
                        <td>
                            <span class="badge badge-{{ $medicamento->cantidad_stock < $medicamento->stock_minimo_alerta ? 'danger' : 'success' }}">
                                {{ $medicamento->cantidad_stock }}
                            </span>
                        </td>
                        <td>{{ $medicamento->stock_minimo_alerta }}</td>
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
                        <td>
                            @if($medicamento->cantidad_stock < $medicamento->stock_minimo_alerta)
                                <span class="badge badge-danger">
                                    <i class="fas fa-exclamation-triangle"></i> Stock Bajo
                                </span>
                            @else
                                <span class="badge badge-success">
                                    <i class="fas fa-check"></i> Disponible
                                </span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('medicamentos.show', $medicamento) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('medicamentos.edit', $medicamento) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('medicamentos.destroy', $medicamento) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de eliminar este medicamento?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay medicamentos registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $medicamentos->links() }}
        </div>
    </div>
</div>
@endsection
