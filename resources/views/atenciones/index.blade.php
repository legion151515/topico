@extends('layouts.app')

@section('page_title', 'Atenciones Registradas')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Atenciones Registradas</h2>
        <a href="{{ route('atenciones.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Atención
        </a>
    </div>

    <div style="padding: 30px;">
        @if($atenciones->count())
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Motivo</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($atenciones as $atencion)
                        <tr>
                            <td>{{ $atencion->fecha ? \Carbon\Carbon::parse($atencion->fecha)->format('d/m/Y') : 'N/A' }}</td>
                            <td>{{ $atencion->paciente->dni ?? 'N/A' }}</td>
                            <td>{{ $atencion->paciente->nombre ?? 'N/A' }}</td>
                            <td>{{ $atencion->paciente->apellido ?? 'N/A' }}</td>
                            <td>{{ $atencion->motivo->nombre ?? $atencion->motivo_otro }}</td>
                            <td>{{ $atencion->hora_entrada }}</td>
                            <td>{{ $atencion->hora_salida ?? '-' }}</td>
                            <td>
                                <a href="{{ route('atenciones.edit', $atencion->id) }}" class="btn btn-warning" style="font-size: 12px;">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('atenciones.destroy', $atencion->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro?')" style="font-size: 12px;">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No hay atenciones registradas.
            </div>
        @endif
    </div>
</div>
@endsection