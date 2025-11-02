@extends('layouts.app')

@section('page_title', 'Motivos de Consulta')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2><i class="fas fa-stethoscope"></i> Motivos de Consulta</h2>
        <a href="{{ route('motivos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Motivo
        </a>
    </div>

    <div class="card-body">
        <!-- Mensajes de éxito/error -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Tabla de motivos -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th width="5%">ID</th>
                        <th width="25%">Nombre</th>
                        <th width="50%">Descripción</th>
                        <th width="10%">Creado</th>
                        <th width="10%">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($motivos as $motivo)
                        <tr>
                            <td>{{ $motivo->id }}</td>
                            <td><strong>{{ $motivo->nombre }}</strong></td>
                            <td>{{ $motivo->descripcion ?? '-' }}</td>
                            <td>{{ $motivo->created_at ? $motivo->created_at->format('d/m/Y') : '-' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('motivos.edit', $motivo->id) }}"
                                       class="btn btn-sm btn-warning"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('motivos.destroy', $motivo->id) }}"
                                          method="POST"
                                          style="display: inline;"
                                          onsubmit="return confirm('¿Estás seguro de eliminar este motivo?\n\nNOTA: No podrás eliminarlo si está siendo usado en atenciones registradas.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                <i class="fas fa-info-circle"></i> No hay motivos de consulta registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Información adicional -->
        <div class="alert alert-info mt-3">
            <i class="fas fa-info-circle"></i> <strong>Total de motivos registrados:</strong> {{ $motivos->count() }}
        </div>
    </div>
</div>
@endsection
