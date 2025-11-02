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

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($atenciones->count())
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Paciente</th>
                            <th>DNI</th>
                            <th>Carrera</th>
                            <th>Acrónimo</th>
                            <th>Motivo</th>
                            <th>Hora Entrada</th>
                            <th>Hora Salida</th>
                            <th>Medicamentos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($atenciones as $atencion)
                            <tr>
                                <td>{{ $atencion->fecha ? \Carbon\Carbon::parse($atencion->fecha)->format('d/m/Y') : $atencion->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if($atencion->paciente)
                                        {{ $atencion->paciente->nombre }} {{ $atencion->paciente->apellido }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td><strong>{{ $atencion->paciente->dni ?? 'N/A' }}</strong></td>
                                <td>
                                    @if($atencion->paciente && $atencion->paciente->carrera)
                                        {{ $atencion->paciente->carrera->nombre }}
                                    @elseif($atencion->paciente && $atencion->paciente->otros_especificacion)
                                        {{ $atencion->paciente->otros_especificacion }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($atencion->paciente && $atencion->paciente->carrera && $atencion->paciente->carrera->acronimo)
                                        <span class="badge badge-secondary">{{ $atencion->paciente->carrera->acronimo }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($atencion->motivo)
                                        <span class="badge badge-info">{{ $atencion->motivo->nombre }}</span>
                                    @else
                                        {{ $atencion->motivo_otro }}
                                    @endif
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
                                    <span class="badge badge-primary">{{ $atencion->medicamentos->count() }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('atenciones.show', $atencion->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('atenciones.edit', $atencion->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('atenciones.destroy', $atencion->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de eliminar esta atención?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No hay atenciones registradas.
            </div>
        @endif
    </div>
</div>
@endsection