@extends('layouts.app')

@section('page_title', 'Gestión de Pacientes')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Pacientes Registrados</h2>
        <div class="float-right" style="display: flex; gap: 10px;">
            <a href="{{ route('pacientes.importar') }}" class="btn btn-success">
                <i class="fas fa-file-import"></i> Importar desde Excel
            </a>
            <a href="{{ route('pacientes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Paciente
            </a>
        </div>
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
                    <th>DNI</th>
                    <th>Nombre Completo</th>
                    <th>Edad</th>
                    <th>Carrera/Área</th>
                    <th>Atenciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pacientes as $paciente)
                    <tr>
                        <td><strong>{{ $paciente->dni }}</strong></td>
                        <td>{{ $paciente->nombre }} {{ $paciente->apellido }}</td>
                        <td>{{ $paciente->edad }} años</td>
                        <td>
                            @if($paciente->carrera)
                                <span class="badge badge-info">{{ $paciente->carrera->acronimo }}</span>
                                {{ $paciente->carrera->nombre }}
                            @elseif($paciente->nivel)
                                <span class="badge badge-success">{{ $paciente->nivel->acronimo }}</span>
                                {{ $paciente->nivel->nombre }}
                            @else
                                <span class="badge badge-secondary">{{ $paciente->otros_especificacion ?? '-' }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-primary">{{ $paciente->atenciones->count() }}</span>
                        </td>
                        <td>
                            <a href="{{ route('pacientes.show', $paciente) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('pacientes.edit', $paciente) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('pacientes.destroy', $paciente) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de eliminar este paciente?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay pacientes registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $pacientes->links() }}
        </div>
    </div>
</div>
@endsection
