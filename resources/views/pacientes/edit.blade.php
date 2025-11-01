@extends('layouts.app')

@section('page_title', 'Editar Paciente')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Editar Paciente</h2>
    </div>

    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pacientes.update', $paciente) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>DNI *</label>
                        <input type="text" name="dni" class="form-control @error('dni') is-invalid @enderror"
                               value="{{ old('dni', $paciente->dni) }}" required>
                        @error('dni')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nombre *</label>
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                               value="{{ old('nombre', $paciente->nombre) }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Apellido *</label>
                        <input type="text" name="apellido" class="form-control @error('apellido') is-invalid @enderror"
                               value="{{ old('apellido', $paciente->apellido) }}" required>
                        @error('apellido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Edad *</label>
                        <input type="number" name="edad" class="form-control @error('edad') is-invalid @enderror"
                               value="{{ old('edad', $paciente->edad) }}" min="0" max="150" required>
                        @error('edad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="form-group">
                        <label>Carrera/Área</label>
                        <select name="carrera_id" class="form-control @error('carrera_id') is-invalid @enderror">
                            <option value="">-- Selecciona --</option>
                            @foreach($carreras as $carrera)
                                <option value="{{ $carrera->id }}"
                                    {{ old('carrera_id', $paciente->carrera_id) == $carrera->id ? 'selected' : '' }}>
                                    {{ $carrera->nombre }} ({{ $carrera->acronimo }})
                                </option>
                            @endforeach
                        </select>
                        @error('carrera_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Otros (especificar)</label>
                        <input type="text" name="otros_especificacion"
                               class="form-control @error('otros_especificacion') is-invalid @enderror"
                               value="{{ old('otros_especificacion', $paciente->otros_especificacion) }}"
                               placeholder="Si no pertenece a ninguna carrera">
                        @error('otros_especificacion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <hr>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Actualizar Paciente
            </button>
            <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </form>
    </div>
</div>
@endsection
