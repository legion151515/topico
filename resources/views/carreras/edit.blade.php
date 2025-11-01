@extends('layouts.app')

@section('page_title', 'Editar Carrera')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Editar Carrera / Programa</h2>
    </div>

    <div class="card-body">
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <strong>Nota:</strong> Los campos y opciones se adaptarán automáticamente según la categoría que selecciones.
        </div>

        <form action="{{ route('carreras.update', $carrera) }}" method="POST" id="formCarrera">
            @csrf
            @method('PUT')

            <!-- Categoría -->
            <div class="form-group">
                <label><i class="fas fa-layer-group"></i> Categoría *</label>
                <select id="categoria" name="categoria" class="form-control" required onchange="actualizarCampos()">
                    <option value="">-- Selecciona una categoría --</option>
                    <option value="Tecnológico" {{ $carrera->categoria == 'Tecnológico' ? 'selected' : '' }}>Tecnológico</option>
                    <option value="Pedagógico" {{ $carrera->categoria == 'Pedagógico' ? 'selected' : '' }}>Pedagógico</option>
                    <option value="Escuela" {{ $carrera->categoria == 'Escuela' ? 'selected' : '' }}>Escuela</option>
                    <option value="Otros" {{ $carrera->categoria == 'Otros' ? 'selected' : '' }}>Otros</option>
                </select>
                <small class="form-text text-muted">Selecciona el tipo de programa o carrera</small>
            </div>

            <!-- Nombre (siempre visible excepto para "Otros") -->
            <div class="form-group" id="div_nombre">
                <label><i class="fas fa-graduation-cap"></i> Nombre del Programa / Carrera *</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $carrera->nombre }}" placeholder="Ej: Computación e Informática, 5to Año Secundaria">
                <small class="form-text text-muted" id="help_nombre">
                    Ingrese el nombre completo del programa o carrera
                </small>
            </div>

            <!-- Campo de texto libre para "Otros" -->
            <div class="form-group" id="div_otros" style="display: none;">
                <label><i class="fas fa-keyboard"></i> Descripción Personalizada *</label>
                <input type="text" id="nombre_otros" name="nombre_otros" class="form-control" value="{{ $carrera->nombre }}" placeholder="Ej: Personal Administrativo, Docente, Visitante">
                <small class="form-text text-muted">
                    Especifique libremente el tipo de área, cargo o grupo
                </small>
            </div>

            <!-- Acrónimo (solo para Tecnológico y Pedagógico) -->
            <div class="form-group" id="div_acronimo" style="display: none;">
                <label><i class="fas fa-tag"></i> Acrónimo / Código *</label>
                <input type="text" id="acronimo" name="acronimo" class="form-control" value="{{ $carrera->acronimo }}" placeholder="Ej: SI, AD, CF, ENF" maxlength="10">
                <small class="form-text text-muted">
                    Código corto para identificar rápidamente la carrera (opcional pero recomendado)
                </small>
            </div>

            <!-- Información específica para Escuela -->
            <div id="info_escuela" style="display: none;">
                <div class="alert alert-success">
                    <i class="fas fa-school"></i>
                    <strong>Escuela:</strong> Estás editando un grado/nivel educativo. No necesitas ingresar acrónimo.
                    Ejemplos: Inicial 3 años, 1er Grado Primaria, 5to Año Secundaria.
                </div>
            </div>

            <!-- Información específica para Tecnológico/Pedagógico -->
            <div id="info_tecnico" style="display: none;">
                <div class="alert alert-primary">
                    <i class="fas fa-laptop-code"></i>
                    <strong>Programa Técnico/Tecnológico:</strong> Registra el nombre completo y un acrónimo para facilitar el registro.
                </div>
            </div>

            <!-- Botones -->
            <div class="form-group" style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Actualizar Carrera / Programa
                </button>
                <a href="{{ route('carreras.index') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function actualizarCampos() {
    const categoria = document.getElementById('categoria').value;

    // Ocultar todos los campos opcionales primero
    document.getElementById('div_nombre').style.display = 'none';
    document.getElementById('div_otros').style.display = 'none';
    document.getElementById('div_acronimo').style.display = 'none';
    document.getElementById('info_escuela').style.display = 'none';
    document.getElementById('info_tecnico').style.display = 'none';

    // Remover atributo required de todos
    document.getElementById('nombre').removeAttribute('required');
    document.getElementById('nombre_otros').removeAttribute('required');
    document.getElementById('acronimo').removeAttribute('required');

    // Mostrar campos según la categoría
    if (categoria === 'Escuela') {
        // Para Escuela: solo nombre, sin acrónimo
        document.getElementById('div_nombre').style.display = 'block';
        document.getElementById('info_escuela').style.display = 'block';
        document.getElementById('nombre').setAttribute('required', 'required');
        document.getElementById('help_nombre').textContent = 'Ej: Inicial 3 años, 1er Grado Primaria, 5to Año Secundaria';

    } else if (categoria === 'Tecnológico' || categoria === 'Pedagógico') {
        // Para Tecnológico/Pedagógico: nombre y acrónimo
        document.getElementById('div_nombre').style.display = 'block';
        document.getElementById('div_acronimo').style.display = 'block';
        document.getElementById('info_tecnico').style.display = 'block';
        document.getElementById('nombre').setAttribute('required', 'required');
        document.getElementById('help_nombre').textContent = 'Ej: Computación e Informática, Administración de Empresas, Educación Inicial';

    } else if (categoria === 'Otros') {
        // Para Otros: campo de texto libre
        document.getElementById('div_otros').style.display = 'block';
        document.getElementById('nombre_otros').setAttribute('required', 'required');

    } else {
        // Sin categoría seleccionada
        document.getElementById('div_nombre').style.display = 'none';
    }
}

// Validación antes de enviar
document.getElementById('formCarrera').addEventListener('submit', function(e) {
    const categoria = document.getElementById('categoria').value;

    if (!categoria) {
        e.preventDefault();
        alert('Por favor selecciona una categoría');
        return false;
    }

    // Asignar el valor correcto al campo nombre según la categoría
    if (categoria === 'Otros') {
        const nombreOtros = document.getElementById('nombre_otros').value.trim();
        if (!nombreOtros) {
            e.preventDefault();
            alert('Por favor ingresa una descripción para "Otros"');
            return false;
        }
        // Copiar el valor de nombre_otros a nombre para enviar al servidor
        document.getElementById('nombre').value = nombreOtros;
    } else {
        const nombre = document.getElementById('nombre').value.trim();
        if (!nombre) {
            e.preventDefault();
            alert('Por favor ingresa el nombre del programa o carrera');
            return false;
        }
    }

    return true;
});

// Inicializar al cargar la página con la categoría actual
document.addEventListener('DOMContentLoaded', function() {
    actualizarCampos();
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

.form-group label i {
    color: #3498db;
    margin-right: 5px;
}

.form-control {
    padding: 10px;
    border: 2px solid #e0e0e0;
    border-radius: 5px;
    transition: border-color 0.3s;
}

.form-control:focus {
    border-color: #3498db;
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.2);
}

.alert {
    border-radius: 5px;
    padding: 15px;
}

.btn-lg {
    padding: 12px 30px;
    font-size: 16px;
}
</style>
@endsection
