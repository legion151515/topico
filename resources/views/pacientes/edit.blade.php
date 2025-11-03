@extends('layouts.app')

@section('page_title', 'Editar Paciente')

@push('head')
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Editar Paciente</h2>
    </div>

    <form action="{{ route('pacientes.update', $paciente) }}" method="POST" id="formPaciente">
        @csrf
        @method('PUT')

        <div style="padding: 30px;">

            <!-- ERRORES -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong><i class="fas fa-exclamation-triangle"></i> Errores:</strong>
                    <ul style="margin-bottom: 0; margin-top: 10px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- INFORMACIÓN DEL PACIENTE -->
            <h3 style="color: #1e3c72; margin-bottom: 20px; font-size: 16px; font-weight: 600;">
                <i class="fas fa-user-injured"></i> Información del Paciente
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 30px; background: #f8f9fa; padding: 20px; border-radius: 8px;">

                <!-- DNI -->
                <div class="form-group">
                    <label><i class="fas fa-id-card"></i> DNI *</label>
                    <input type="text"
                           id="dni"
                           name="dni"
                           class="form-control"
                           placeholder="Ej: 75832984"
                           inputmode="numeric"
                           maxlength="8"
                           required
                           readonly
                           style="background-color: #f0f0f0; border: 2px solid #ddd;">
                </div>

                <!-- NOMBRE -->
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Nombre *</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre del paciente" required>
                </div>

                <!-- APELLIDO -->
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Apellido *</label>
                    <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Apellido del paciente" required>
                </div>

                <!-- CATEGORÍA (Área) -->
                <div class="form-group">
                    <label><i class="fas fa-layer-group"></i> Categoría / Área *</label>
                    <select id="categoria" name="categoria" class="form-control" required onchange="cargarCarreras()">
                        <option value="">-- Selecciona categoría --</option>
                        <option value="Tecnológico">Tecnológico</option>
                        <option value="Pedagógico">Pedagógico</option>
                        <option value="Escuela">Escuela</option>
                        <option value="Otros">Otros</option>
                    </select>
                </div>

                <!-- CARRERA (Subnivel dinámico - Solo para Tecnológico y Pedagógico) -->
                <div class="form-group" id="div_carrera" style="display:none;">
                    <label><i class="fas fa-graduation-cap"></i> Carrera / Subnivel *</label>
                    <select id="carrera_id" name="carrera_id" class="form-control" onchange="actualizarCamposSegunCarrera()">
                        <option value="">-- Selecciona primero una categoría --</option>
                    </select>
                </div>

                <!-- NIVEL ESCUELA (Solo para Escuela) -->
                <div class="form-group" id="div_nivel_escuela" style="display:none;">
                    <label><i class="fas fa-school"></i> Nivel Escuela *</label>
                    <select id="nivel_escuela" name="nivel_escuela" class="form-control" onchange="actualizarCamposNivelEscuela()">
                        <option value="">-- Selecciona nivel --</option>
                        <option value="INICIAL">INICIAL</option>
                        <option value="PRIMARIA">PRIMARIA</option>
                        <option value="SECUNDARIA">SECUNDARIA</option>
                    </select>
                </div>

                <!-- OTROS (Campo de texto libre) -->
                <div class="form-group" id="div_otros" style="display:none;">
                    <label><i class="fas fa-keyboard"></i> Especifique el área o cargo *</label>
                    <input type="text" id="otros_especificacion" name="otros_especificacion" class="form-control" placeholder="Ej: Docente de Contabilidad">
                </div>

                <!-- SEMESTRE (Solo para Tecnológico y Pedagógico) -->
                <div class="form-group" id="div_semestre" style="display:none;">
                    <label><i class="fas fa-book"></i> Semestre *</label>
                    <select id="semestre" name="semestre" class="form-control">
                        <option value="">-- Selecciona semestre --</option>
                    </select>
                </div>

                <!-- AÑOS (Solo para INICIAL) -->
                <div class="form-group" id="div_anios" style="display:none;">
                    <label><i class="fas fa-child"></i> Años *</label>
                    <input type="text" id="anios" name="anios" class="form-control" placeholder="Ej: 3 años, 4 años, 5 años">
                </div>

                <!-- GRADO (Solo para PRIMARIA y SECUNDARIA) -->
                <div class="form-group" id="div_grado" style="display:none;">
                    <label><i class="fas fa-book"></i> Grado *</label>
                    <select id="grado" name="grado" class="form-control">
                        <option value="">-- Selecciona grado --</option>
                    </select>
                </div>

                <!-- EDAD -->
                <div class="form-group">
                    <label><i class="fas fa-birthday-cake"></i> Edad *</label>
                    <input type="number" id="edad" name="edad" class="form-control" placeholder="Edad" min="1" max="120" required>
                </div>

            </div>

            <!-- BOTONES -->
            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar Paciente
                </button>
                <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </div>
    </form>
</div>

<!-- DATOS DEL PACIENTE COMO JSON -->
<script>
    const datosPaciente = {!! json_encode([
        'id' => $paciente->id,
        'dni' => $paciente->dni,
        'nombre' => $paciente->nombre,
        'apellido' => $paciente->apellido,
        'edad' => $paciente->edad,
        'categoria' => $paciente->nivel ? $paciente->nivel->categoria : ($paciente->carrera ? $paciente->carrera->categoria : ''),
        'carrera_id' => $paciente->carrera_id ?? '',
        'semestre' => '',
        'grado' => $paciente->nivel->grado ?? '',
        'nivel_escuela' => $paciente->nivel->nivel_escuela ?? '',
        'anios' => $paciente->nivel->anios ?? '',
        'otros_especificacion' => $paciente->nivel ? $paciente->nivel->otros_especificacion : ($paciente->otros_especificacion ?? ''),
    ]) !!};

    console.log('✅ Datos del paciente cargados:', datosPaciente);

    // Configuración de semestres por categoría
    const configuracion = {
        'Tecnológico': {
            semestres: ['I', 'II', 'III', 'IV', 'V', 'VI']
        },
        'Pedagógico': {
            semestres: ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X']
        }
    };

    // CARGAR DATOS AL INICIAR LA PÁGINA
    window.addEventListener('load', function() {
        // CARGAR DATOS BÁSICOS
        document.getElementById('dni').value = datosPaciente.dni || '';
        document.getElementById('nombre').value = datosPaciente.nombre || '';
        document.getElementById('apellido').value = datosPaciente.apellido || '';
        document.getElementById('edad').value = datosPaciente.edad || '';

        // CARGAR CATEGORÍA Y CAMPOS DINÁMICOS
        if (datosPaciente.categoria) {
            document.getElementById('categoria').value = datosPaciente.categoria;

            setTimeout(() => {
                cargarCarrerasInit();
            }, 300);
        }

        // CARGAR OTROS_ESPECIFICACION si existe
        if (datosPaciente.otros_especificacion) {
            document.getElementById('otros_especificacion').value = datosPaciente.otros_especificacion;
        }
    });

    function cargarCarrerasInit() {
        const categoria = datosPaciente.categoria;
        const carreraSelect = document.getElementById('carrera_id');
        const divCarrera = document.getElementById('div_carrera');
        const divNivelEscuela = document.getElementById('div_nivel_escuela');
        const divOtros = document.getElementById('div_otros');
        const divSemestre = document.getElementById('div_semestre');
        const divGrado = document.getElementById('div_grado');
        const divAnios = document.getElementById('div_anios');

        // Ocultar todos primero
        divCarrera.style.display = 'none';
        divNivelEscuela.style.display = 'none';
        divOtros.style.display = 'none';
        divSemestre.style.display = 'none';
        divGrado.style.display = 'none';
        divAnios.style.display = 'none';

        if (categoria === 'Otros') {
            divOtros.style.display = 'block';
        } else if (categoria === 'Escuela') {
            // Para Escuela, mostrar nivel escuela
            divNivelEscuela.style.display = 'block';

            // SELECCIONAR NIVEL ESCUELA GUARDADO
            if (datosPaciente.nivel_escuela) {
                document.getElementById('nivel_escuela').value = datosPaciente.nivel_escuela;
                console.log('Nivel escuela seleccionado:', datosPaciente.nivel_escuela);

                // Cargar campos según nivel (grado o años)
                setTimeout(() => {
                    actualizarCamposNivelEscuela();

                    // Restaurar grado o años según corresponda
                    if (datosPaciente.nivel_escuela === 'INICIAL' && datosPaciente.anios) {
                        document.getElementById('anios').value = datosPaciente.anios;
                        console.log('Años seleccionado:', datosPaciente.anios);
                    } else if ((datosPaciente.nivel_escuela === 'PRIMARIA' || datosPaciente.nivel_escuela === 'SECUNDARIA') && datosPaciente.grado) {
                        document.getElementById('grado').value = datosPaciente.grado;
                        console.log('Grado seleccionado:', datosPaciente.grado);
                    }
                }, 100);
            }
        } else {
            // Para Tecnológico y Pedagógico
            divCarrera.style.display = 'block';
            divSemestre.style.display = 'block';

            fetch(`/carreras/categoria/${categoria}`)
                .then(response => response.json())
                .then(data => {
                    carreraSelect.innerHTML = '<option value="">-- Selecciona una carrera --</option>';
                    data.forEach(carrera => {
                        const option = document.createElement('option');
                        option.value = carrera.id;
                        option.textContent = `${carrera.nombre} (${carrera.acronimo})`;
                        carreraSelect.appendChild(option);
                    });

                    // SELECCIONAR CARRERA GUARDADA
                    if (datosPaciente.carrera_id) {
                        carreraSelect.value = datosPaciente.carrera_id;
                        console.log('Carrera seleccionada:', datosPaciente.carrera_id);
                    }

                    // LLENAR SEMESTRES
                    if (configuracion[categoria] && configuracion[categoria].semestres) {
                        const semestreSelect = document.getElementById('semestre');
                        semestreSelect.innerHTML = '<option value="">-- Selecciona semestre --</option>';
                        configuracion[categoria].semestres.forEach(semestre => {
                            const option = document.createElement('option');
                            option.value = semestre;
                            option.textContent = `Semestre ${semestre}`;
                            semestreSelect.appendChild(option);
                        });

                        // SELECCIONAR SEMESTRE GUARDADO
                        if (datosPaciente.semestre) {
                            semestreSelect.value = datosPaciente.semestre;
                            console.log('Semestre seleccionado:', datosPaciente.semestre);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error al cargar carreras:', error);
                });
        }
    }

    function cargarCarreras() {
        const categoria = document.getElementById('categoria').value;
        const carreraSelect = document.getElementById('carrera_id');
        const divCarrera = document.getElementById('div_carrera');
        const divNivelEscuela = document.getElementById('div_nivel_escuela');
        const divOtros = document.getElementById('div_otros');
        const divSemestre = document.getElementById('div_semestre');
        const divGrado = document.getElementById('div_grado');
        const divAnios = document.getElementById('div_anios');

        // Resetear todo
        carreraSelect.innerHTML = '<option value="">-- Cargando --</option>';
        divCarrera.style.display = 'none';
        divNivelEscuela.style.display = 'none';
        divOtros.style.display = 'none';
        divSemestre.style.display = 'none';
        divGrado.style.display = 'none';
        divAnios.style.display = 'none';

        if (!categoria) {
            return;
        }

        if (categoria === 'Otros') {
            divOtros.style.display = 'block';
        } else if (categoria === 'Escuela') {
            // Para "Escuela", mostrar select de nivel escuela (INICIAL/PRIMARIA/SECUNDARIA)
            divNivelEscuela.style.display = 'block';
        } else {
            // Para Tecnológico y Pedagógico: cargar carreras de la BD
            divCarrera.style.display = 'block';
            divSemestre.style.display = 'block';

            fetch(`/carreras/categoria/${categoria}`)
                .then(response => response.json())
                .then(data => {
                    carreraSelect.innerHTML = '<option value="">-- Selecciona una carrera --</option>';
                    data.forEach(carrera => {
                        const option = document.createElement('option');
                        option.value = carrera.id;
                        option.textContent = `${carrera.nombre} (${carrera.acronimo})`;
                        carreraSelect.appendChild(option);
                    });

                    // Llenar semestres
                    if (configuracion[categoria] && configuracion[categoria].semestres) {
                        const semestreSelect = document.getElementById('semestre');
                        semestreSelect.innerHTML = '<option value="">-- Selecciona semestre --</option>';
                        configuracion[categoria].semestres.forEach(semestre => {
                            const option = document.createElement('option');
                            option.value = semestre;
                            option.textContent = `Semestre ${semestre}`;
                            semestreSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }

    function actualizarCamposSegunCarrera() {
        // Esta función ya no se usa para Escuela, solo para Tecnológico y Pedagógico si es necesario
        console.log('actualizarCamposSegunCarrera llamada');
    }

    // Actualizar campos según nivel de escuela seleccionado
    function actualizarCamposNivelEscuela() {
        const nivelEscuela = document.getElementById('nivel_escuela').value;
        const divGrado = document.getElementById('div_grado');
        const divAnios = document.getElementById('div_anios');
        const gradoSelect = document.getElementById('grado');

        // Ocultar todos los campos primero
        divGrado.style.display = 'none';
        divAnios.style.display = 'none';
        gradoSelect.innerHTML = '<option value="">-- Selecciona grado --</option>';

        if (nivelEscuela === 'INICIAL') {
            // Mostrar campo de años para INICIAL
            divAnios.style.display = 'block';
        } else if (nivelEscuela === 'PRIMARIA') {
            // Mostrar grados de primaria (1-6)
            divGrado.style.display = 'block';
            for (let i = 1; i <= 6; i++) {
                const option = document.createElement('option');
                option.value = `${i}°`;
                option.textContent = `${i}°`;
                gradoSelect.appendChild(option);
            }
        } else if (nivelEscuela === 'SECUNDARIA') {
            // Mostrar grados de secundaria (1-5)
            divGrado.style.display = 'block';
            for (let i = 1; i <= 5; i++) {
                const option = document.createElement('option');
                option.value = `${i}°`;
                option.textContent = `${i}°`;
                gradoSelect.appendChild(option);
            }
        }
    }

    // Validar antes de enviar
    document.getElementById('formPaciente').addEventListener('submit', function(e) {
        const categoria = document.getElementById('categoria').value;
        const carreraId = document.getElementById('carrera_id').value;
        const otrosEspecificacion = document.getElementById('otros_especificacion').value;

        if (!categoria) {
            alert('Por favor selecciona una categoría');
            e.preventDefault();
            return;
        }

        if (categoria === 'Otros') {
            if (!otrosEspecificacion) {
                alert('Por favor especifica el área o cargo');
                e.preventDefault();
                return;
            }
        } else if (categoria === 'Escuela') {
            const nivelEscuela = document.getElementById('nivel_escuela').value;
            if (!nivelEscuela) {
                alert('Por favor selecciona un nivel de escuela');
                e.preventDefault();
                return;
            }

            if (nivelEscuela === 'INICIAL') {
                const anios = document.getElementById('anios').value;
                if (!anios) {
                    alert('Por favor ingresa los años para el nivel INICIAL');
                    e.preventDefault();
                    return;
                }
            } else if (nivelEscuela === 'PRIMARIA' || nivelEscuela === 'SECUNDARIA') {
                const grado = document.getElementById('grado').value;
                if (!grado) {
                    alert('Por favor selecciona un grado');
                    e.preventDefault();
                    return;
                }
            }
        } else {
            if (!carreraId) {
                alert('Por favor selecciona una carrera');
                e.preventDefault();
                return;
            }
        }
    });
</script>
@endsection
