@extends('layouts.app')

@section('page_title', 'Nueva Carrera')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Crear Nueva Carrera / Programa</h2>
    </div>

    <div class="card-body">
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

        <form action="{{ route('carreras.store') }}" method="POST" id="formCarrera">
            @csrf

            <!-- Categoría -->
            <div class="form-group">
                <label><i class="fas fa-layer-group"></i> Categoría *</label>
                <select id="categoria" name="categoria" class="form-control" required onchange="mostrarCampos()">
                    <option value="">-- Selecciona una categoría --</option>
                    <option value="Escuela" {{ old('categoria') == 'Escuela' ? 'selected' : '' }}>Escuela (Inicial/Primaria/Secundaria)</option>
                    <option value="Tecnológico" {{ old('categoria') == 'Tecnológico' ? 'selected' : '' }}>Tecnológico</option>
                    <option value="Pedagógico" {{ old('categoria') == 'Pedagógico' ? 'selected' : '' }}>Pedagógico</option>
                    <option value="Otros" {{ old('categoria') == 'Otros' ? 'selected' : '' }}>Otros</option>
                </select>
            </div>

            <!-- Para ESCUELA: Select con niveles predefinidos -->
            <div id="campos_escuela" style="display: none;">
                <div class="alert alert-success">
                    <i class="fas fa-school"></i> <strong>Escuela:</strong> Selecciona el nivel educativo
                </div>

                <div class="form-group">
                    <label><i class="fas fa-graduation-cap"></i> Nivel Educativo *</label>
                    <select id="nivel_escuela" name="nivel_escuela" class="form-control">
                        <option value="">-- Selecciona nivel --</option>
                        <option value="Inicial">Inicial</option>
                        <option value="Primaria">Primaria</option>
                        <option value="Secundaria">Secundaria</option>
                    </select>
                </div>
            </div>

            <!-- Para TECNOLÓGICO / PEDAGÓGICO: Nombre y Acrónimo -->
            <div id="campos_tecnico" style="display: none;">
                <div class="alert alert-primary">
                    <i class="fas fa-laptop-code"></i> <strong>Programa Técnico:</strong> Ingresa nombre completo y acrónimo
                </div>

                <div class="form-group">
                    <label><i class="fas fa-graduation-cap"></i> Nombre del Programa *</label>
                    <input type="text" id="nombre_tecnico" name="nombre_tecnico" class="form-control" placeholder="Ej: Computación e Informática, Administración de Empresas">
                </div>

                <div class="form-group">
                    <label><i class="fas fa-tag"></i> Acrónimo</label>
                    <input type="text" id="acronimo_tecnico" name="acronimo_tecnico" class="form-control" placeholder="Ej: SI, AD, CF" maxlength="10">
                </div>
            </div>

            <!-- Para OTROS: Campo de texto libre -->
            <div id="campos_otros" style="display: none;">
                <div class="alert alert-info">
                    <i class="fas fa-pen"></i> <strong>Otros:</strong> Describe libremente el área o grupo
                </div>

                <div class="form-group">
                    <label><i class="fas fa-keyboard"></i> Descripción *</label>
                    <input type="text" id="descripcion_otros" name="descripcion_otros" class="form-control" placeholder="Ej: Personal Administrativo, Docente, Visitante">
                </div>
            </div>

            <!-- Campo oculto para enviar el nombre final -->
            <input type="hidden" id="nombre" name="nombre">
            <input type="hidden" id="acronimo" name="acronimo">

            <div class="form-group" style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <a href="{{ route('carreras.index') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function mostrarCampos() {
    const categoria = document.getElementById('categoria').value;

    // Ocultar todos
    document.getElementById('campos_escuela').style.display = 'none';
    document.getElementById('campos_tecnico').style.display = 'none';
    document.getElementById('campos_otros').style.display = 'none';

    // Mostrar según categoría
    if (categoria === 'Escuela') {
        document.getElementById('campos_escuela').style.display = 'block';
    } else if (categoria === 'Tecnológico' || categoria === 'Pedagógico') {
        document.getElementById('campos_tecnico').style.display = 'block';
    } else if (categoria === 'Otros') {
        document.getElementById('campos_otros').style.display = 'block';
    }
}

// Antes de enviar, copiar valores a los campos ocultos
document.getElementById('formCarrera').addEventListener('submit', function(e) {
    const categoria = document.getElementById('categoria').value;

    if (!categoria) {
        e.preventDefault();
        alert('Por favor selecciona una categoría');
        return false;
    }

    if (categoria === 'Escuela') {
        const nivel = document.getElementById('nivel_escuela').value;
        if (!nivel) {
            e.preventDefault();
            alert('Por favor selecciona el nivel educativo');
            return false;
        }
        document.getElementById('nombre').value = nivel;
        document.getElementById('acronimo').value = '';

    } else if (categoria === 'Tecnológico' || categoria === 'Pedagógico') {
        const nombre = document.getElementById('nombre_tecnico').value.trim();
        if (!nombre) {
            e.preventDefault();
            alert('Por favor ingresa el nombre del programa');
            return false;
        }
        document.getElementById('nombre').value = nombre;
        document.getElementById('acronimo').value = document.getElementById('acronimo_tecnico').value.trim();

    } else if (categoria === 'Otros') {
        const desc = document.getElementById('descripcion_otros').value.trim();
        if (!desc) {
            e.preventDefault();
            alert('Por favor ingresa una descripción');
            return false;
        }
        document.getElementById('nombre').value = desc;
        document.getElementById('acronimo').value = '';
    }

    return true;
});

// Inicializar campos al cargar la página (útil cuando hay errores de validación)
document.addEventListener('DOMContentLoaded', function() {
    @if(old('categoria'))
        mostrarCampos();
    @endif
});
</script>

<style>
.form-group {
    margin-bottom: 20px;
}
.form-group label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
}
.form-control {
    padding: 10px;
    border: 2px solid #e0e0e0;
    border-radius: 5px;
}
.alert {
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 20px;
}
.btn-lg {
    padding: 12px 30px;
    font-size: 16px;
}
</style>
@endsection
