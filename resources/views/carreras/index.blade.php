@extends('layouts.app')

@section('page_title', 'Gestión de Carreras')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Carreras / Áreas</h2>
        <a href="{{ route('carreras.create') }}" class="btn btn-primary float-right">
            <i class="fas fa-plus"></i> Nueva Carrera
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
                    <th>Categoría</th>
                    <th>Nombre</th>
                    <th>Acrónimo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carreras as $carrera)
                    <tr>
                        <td><span class="badge badge-info">{{ $carrera->categoria }}</span></td>
                        <td>{{ $carrera->nombre }}</td>
                        <td><strong>{{ $carrera->acronimo }}</strong></td>
                        <td>
                            <a href="{{ route('carreras.show', $carrera) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('carreras.edit', $carrera) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('carreras.destroy', $carrera) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de eliminar esta carrera?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection