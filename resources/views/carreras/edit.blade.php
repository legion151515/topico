@extends('layouts.app')

@section('page_title', 'Editar Carrera')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Editar Carrera</h2>
    </div>

    <div class="card-body">
        <form action="{{ route('carreras.update', $carrera) }}" method="POST">
            @csrf @method('PUT')

            <div class="form-group">
                <label>Categoría *</label>
                <select name="categoria" class="form-control" required>
                    <option value="Tecnológico" {{ $carrera->categoria == 'Tecnológico' ? 'selected' : '' }}>Tecnológico</option>
                    <option value="Pedagógico" {{ $carrera->categoria == 'Pedagógico' ? 'selected' : '' }}>Pedagógico</option>
                    <option value="Escuela" {{ $carrera->categoria == 'Escuela' ? 'selected' : '' }}>Escuela</option>
                    <option value="Otros" {{ $carrera->categoria == 'Otros' ? 'selected' : '' }}>Otros</option>
                </select>
            </div>

            <div class="form-group">
                <label>Nombre *</label>
                <input type="text" name="nombre" class="form-control" value="{{ $carrera->nombre }}" required>
            </div>

            <div class="form-group">
                <label>Acrónimo *</label>
                <input type="text" name="acronimo" class="form-control" value="{{ $carrera->acronimo }}" required>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Actualizar
            </button>
            <a href="{{ route('carreras.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </form>
    </div>
</div>
@endsection