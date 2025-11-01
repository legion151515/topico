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
                    <option value="Tecnológico" {{ old('categoria') == 'Tecnológico' ? 'selected' : '' }}>Tecnológico</option>
                    <option value="Pedagógico" {{ old('categoria') == 'Pedagógico' ? 'selected' : '' }}>Pedagógico</option>
                    <option value="Escuela" {{ old('categoria') == 'Escuela' ? 'selected' : '' }}>Escuela</option>
                    <option value="Otros" {{ old('categoria') == 'Otros' ? 'selected' : '' }}>Otros</option>
                </select>
            </div>

            <!-- PARA TECNOLÓGICO Y PEDAGÓGICO -->
            <div id="campos_tecnico_pedagogico" style="display: none;">
                <div class="alert alert-info">
                    <i class="fas fa-laptop-code"></i> <strong>Programa Técnico/Tecnológico:</strong> Ingresa el nombre completo y el acrónimo de la carrera.
                </div>

                <div class="form-group">
                    <label><i class="fas fa-graduation-cap"></i> Nombre de la Carrera *</label>
                    <input type="text" id="nombre_tecnico" class="form-control" placeholder="Ej: Computación e Informática, Administración de Empresas" value="{{ old('nombre_tecnico') }}">
                    <small class="form-text text-muted">Nombre completo del programa o carrera</small>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-tag"></i> Acrónimo *</label>
                    <input type="text" id="acronimo_tecnico" class="form-control" placeholder="Ej: CI, AD, EI" maxlength="10" value="{{ old('acronimo_tecnico') }}">
                    <small class="form-text text-muted">Código corto para identificar la carrera</small>
                </div>
            </div>

            <!-- PARA ESCUELA -->
            <div id="campos_escuela" style="display: none;">
                <div class="alert alert-success">
                    <i class="fas fa-school"></i> <strong>Escuela:</strong> Selecciona el nivel educativo y luego el año/grado correspondiente.
                </div>

                <div class="form-group">
                    <label><i class="fas fa-book"></i> Nivel Educativo *</label>
                    <select id="nivel_escuela" class="form-control" onchange="mostrarGradosOAnios()">
                        <option value="">-- Selecciona nivel --</option>
                        <option value="Inicial" {{ old('nivel_escuela') == 'Inicial' ? 'selected' : '' }}>Inicial</option>
                        <option value="Primaria" {{ old('nivel_escuela') == 'Primaria' ? 'selected' : '' }}>Primaria</option>
                        <option value="Secundaria" {{ old('nivel_escuela') == 'Secundaria' ? 'selected' : '' }}>Secundaria</option>
                    </select>
                </div>

                <!-- Para Inicial: Años -->
                <div id="div_anios" class="form-group" style="display: none;">
                    <label><i class="fas fa-child"></i> Años *</label>
                    <select id="anios_escuela" class="form-control">
                        <option value="">-- Selecciona años --</option>
                        <option value="3 años">3 años</option>
                        <option value="4 años">4 años</option>
                        <option value="5 años">5 años</option>
                    </select>
                </div>

                <!-- Para Primaria/Secundaria: Grado -->
                <div id="div_grado_primaria" class="form-group" style="display: none;">
                    <label><i class="fas fa-award"></i> Grado de Primaria *</label>
                    <select id="grado_primaria" class="form-control">
                        <option value="">-- Selecciona grado --</option>
                        <option value="1° Primaria">1° Primaria</option>
                        <option value="2° Primaria">2° Primaria</option>
                        <option value="3° Primaria">3° Primaria</option>
                        <option value="4° Primaria">4° Primaria</option>
                        <option value="5° Primaria">5° Primaria</option>
                        <option value="6° Primaria">6° Primaria</option>
                    </select>
                </div>

                <div id="div_grado_secundaria" class="form-group" style="display: none;">
                    <label><i class="fas fa-award"></i> Grado de Secundaria *</label>
                    <select id="grado_secundaria" class="form-control">
                        <option value="">-- Selecciona grado --</option>
                        <option value="1° Secundaria">1° Secundaria</option>
                        <option value="2° Secundaria">2° Secundaria</option>
                        <option value="3° Secundaria">3° Secundaria</option>
                        <option value="4° Secundaria">4° Secundaria</option>
                        <option value="5° Secundaria">5° Secundaria</option>
                    </select>
                </div>
            </div>

            <!-- PARA OTROS -->
            <div id="campos_otros" style="display: none;">
                <div class="alert alert-warning">
                    <i class="fas fa-keyboard"></i> <strong>Otros:</strong> Ingresa libremente el nombre del área, cargo o grupo.
                </div>

                <div class="form-group">
                    <label><i class="fas fa-edit"></i> Descripción *</label>
                    <input type="text" id="descripcion_otros" class="form-control" placeholder="Ej: Personal Administrativo, Docente, Visitante" value="{{ old('descripcion_otros') }}">
                    <small class="form-text text-muted">Especifica el tipo de área o cargo</small>
                </div>
            </div>

            <!-- Campos ocultos para enviar al backend -->
            <input type="hidden" id="nombre" name="nombre">
            <input type="hidden" id="acronimo" name="acronimo">
            <input type="hidden" id="anios" name="anios">
            <input type="hidden" id="grado" name="grado">

            <!-- Botones -->
            <div class="form-group" style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Guardar Carrera / Programa
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

    // Ocultar todos los campos
    document.getElementById('campos_tecnico_pedagogico').style.display = 'none';
    document.getElementById('campos_escuela').style.display = 'none';
    document.getElementById('campos_otros').style.display = 'none';

    // Mostrar según categoría
    if (categoria === 'Tecnológico' || categoria === 'Pedagógico') {
        document.getElementById('campos_tecnico_pedagogico').style.display = 'block';
    } else if (categoria === 'Escuela') {
        document.getElementById('campos_escuela').style.display = 'block';
    } else if (categoria === 'Otros') {
        document.getElementById('campos_otros').style.display = 'block';
    }
}

function mostrarGradosOAnios() {
    const nivel = document.getElementById('nivel_escuela').value;

    // Ocultar todos
    document.getElementById('div_anios').style.display = 'none';
    document.getElementById('div_grado_primaria').style.display = 'none';
    document.getElementById('div_grado_secundaria').style.display = 'none';

    // Mostrar según nivel
    if (nivel === 'Inicial') {
        document.getElementById('div_anios').style.display = 'block';
    } else if (nivel === 'Primaria') {
        document.getElementById('div_grado_primaria').style.display = 'block';
    } else if (nivel === 'Secundaria') {
        document.getElementById('div_grado_secundaria').style.display = 'block';
    }
}

// Validación y preparación antes de enviar
document.getElementById('formCarrera').addEventListener('submit', function(e) {
    const categoria = document.getElementById('categoria').value;

    if (!categoria) {
        e.preventDefault();
        alert('Por favor selecciona una categoría');
        return false;
    }

    if (categoria === 'Tecnológico' || categoria === 'Pedagógico') {
        const nombre = document.getElementById('nombre_tecnico').value.trim();
        const acronimo = document.getElementById('acronimo_tecnico').value.trim();

        if (!nombre) {
            e.preventDefault();
            alert('Por favor ingresa el nombre de la carrera');
            return false;
        }

        if (!acronimo) {
            e.preventDefault();
            alert('Por favor ingresa el acrónimo');
            return false;
        }

        // Copiar a campos ocultos
        document.getElementById('nombre').value = nombre;
        document.getElementById('acronimo').value = acronimo;
        document.getElementById('anios').value = '';
        document.getElementById('grado').value = '';

    } else if (categoria === 'Escuela') {
        const nivel = document.getElementById('nivel_escuela').value;

        if (!nivel) {
            e.preventDefault();
            alert('Por favor selecciona el nivel educativo');
            return false;
        }

        let nombreFinal = '';
        let aniosValue = '';
        let gradoValue = '';

        if (nivel === 'Inicial') {
            const anios = document.getElementById('anios_escuela').value;
            if (!anios) {
                e.preventDefault();
                alert('Por favor selecciona los años');
                return false;
            }
            nombreFinal = anios; // "3 años", "4 años", "5 años"
            aniosValue = anios;
        } else if (nivel === 'Primaria') {
            const grado = document.getElementById('grado_primaria').value;
            if (!grado) {
                e.preventDefault();
                alert('Por favor selecciona el grado de primaria');
                return false;
            }
            nombreFinal = grado; // "1° Primaria", "2° Primaria", etc.
            gradoValue = grado;
        } else if (nivel === 'Secundaria') {
            const grado = document.getElementById('grado_secundaria').value;
            if (!grado) {
                e.preventDefault();
                alert('Por favor selecciona el grado de secundaria');
                return false;
            }
            nombreFinal = grado; // "1° Secundaria", "2° Secundaria", etc.
            gradoValue = grado;
        }

        // Copiar a campos ocultos
        document.getElementById('nombre').value = nombreFinal;
        document.getElementById('acronimo').value = ''; // No aplica para Escuela
        document.getElementById('anios').value = aniosValue;
        document.getElementById('grado').value = gradoValue;

    } else if (categoria === 'Otros') {
        const descripcion = document.getElementById('descripcion_otros').value.trim();

        if (!descripcion) {
            e.preventDefault();
            alert('Por favor ingresa una descripción');
            return false;
        }

        // Copiar a campos ocultos
        document.getElementById('nombre').value = descripcion;
        document.getElementById('acronimo').value = ''; // No aplica para Otros
        document.getElementById('anios').value = '';
        document.getElementById('grado').value = '';
    }

    return true;
});

// Inicializar campos al cargar (útil cuando hay errores de validación)
document.addEventListener('DOMContentLoaded', function() {
    @if(old('categoria'))
        mostrarCampos();
        @if(old('nivel_escuela'))
            mostrarGradosOAnios();
        @endif
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
