@extends('layouts.app')

@section('page_title', 'Nuevo Motivo de Consulta')

@section('content')
<div class="card">
    <div class="card-header">
        <h2><i class="fas fa-plus-circle"></i> Registrar Nuevo Motivo de Consulta</h2>
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

        <form action="{{ route('motivos.store') }}" method="POST">
            @csrf

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
                               value="{{ old('nombre') }}"
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
                                  maxlength="1000">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Puedes agregar detalles adicionales sobre este motivo de consulta
                        </small>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Motivo
                </button>
                <a href="{{ route('motivos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Información adicional -->
<div class="card mt-3">
    <div class="card-body">
        <h5><i class="fas fa-info-circle text-info"></i> Información</h5>
        <ul class="mb-0">
            <li>Los motivos de consulta aparecerán en el formulario de atenciones</li>
            <li>El nombre debe ser único y descriptivo</li>
            <li>La descripción es opcional pero ayuda al personal de tópico</li>
            <li>Puedes editar o eliminar motivos desde el listado principal</li>
        </ul>
    </div>
</div>
@endsection
