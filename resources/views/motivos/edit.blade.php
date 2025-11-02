@extends('layouts.app')

@section('page_title', 'Editar Motivo de Consulta')

@section('content')
<div class="card">
    <div class="card-header">
        <h2><i class="fas fa-edit"></i> Editar Motivo de Consulta</h2>
    </div>

    <div class="card-body">
        <!-- Mostrar errores de validación -->
        @if($errors->any())
            <div class="alert alert-danger">
                <strong><i class="fas fa-exclamation-triangle"></i> Errores de validación:</strong>
                <ul style="margin-bottom: 0; margin-top: 10px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('motivos.update', $motivo->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="nombre">
                            <i class="fas fa-tag"></i> Nombre del Motivo *
                        </label>
                        <input type="text"
                               id="nombre"
                               name="nombre"
                               class="form-control @error('nombre') is-invalid @enderror"
                               value="{{ old('nombre', $motivo->nombre) }}"
                               placeholder="Ej: Dolor de cabeza, Fiebre, Mareos..."
                               required
                               maxlength="255">
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Ingresa un nombre claro y descriptivo del motivo de consulta
                        </small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="descripcion">
                            <i class="fas fa-align-left"></i> Descripción (Opcional)
                        </label>
                        <textarea id="descripcion"
                                  name="descripcion"
                                  class="form-control @error('descripcion') is-invalid @enderror"
                                  rows="4"
                                  placeholder="Ej: Cefalea común, migraña, dolor tensional..."
                                  maxlength="1000">{{ old('descripcion', $motivo->descripcion) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Puedes agregar detalles adicionales sobre este motivo de consulta
                        </small>
                    </div>
                </div>
            </div>

            <!-- Información del registro -->
            <div class="alert alert-light border">
                <small class="text-muted">
                    <strong>ID:</strong> {{ $motivo->id }} |
                    <strong>Creado:</strong> {{ $motivo->created_at ? $motivo->created_at->format('d/m/Y H:i') : '-' }} |
                    <strong>Última modificación:</strong> {{ $motivo->updated_at ? $motivo->updated_at->format('d/m/Y H:i') : '-' }}
                </small>
            </div>

            <!-- Botones -->
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar Motivo
                </button>
                <a href="{{ route('motivos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Advertencia -->
<div class="card mt-3">
    <div class="card-body">
        <h5><i class="fas fa-exclamation-triangle text-warning"></i> Advertencia</h5>
        <p class="mb-0">
            Ten cuidado al modificar motivos que ya están siendo usados en atenciones registradas.
            Los cambios se reflejarán en todas las atenciones que usen este motivo.
        </p>
    </div>
</div>
@endsection
