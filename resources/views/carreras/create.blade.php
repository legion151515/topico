@extends('layouts.app')

@section('page_title', 'Nueva Carrera')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Crear Nueva Carrera</h2>
    </div>

    <div class="card-body">
        <form action="{{ route('carreras.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Categoría *</label>
                <select name="categoria" class="form-control" required>
                    <option value="">-- Selecciona --</option>
                    <option value="Tecnológico">Tecnológico</option>
                    <option value="Pedagógico">Pedagógico</option>
                    <option value="Escuela">Escuela</option>
                    <option value="Otros">Otros</option>
                </select>
            </div>

            <div class="form-group">
                <label>Nombre *</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Acrónimo *</label>
                <input type="text" name="acronimo" class="form-control" placeholder="Ej: SI, AD, INI" required>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
            <a href="{{ route('carreras.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </form>
    </div>
</div>
@endsection