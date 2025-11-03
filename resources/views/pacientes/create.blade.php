@extends('layouts.app')

@section('page_title', 'Nuevo Paciente')

@push('head')
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Registrar Nuevo Paciente</h2>
    </div>

    <form action="{{ route('pacientes.store') }}" method="POST" id="formPaciente">
        @csrf

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

                <!-- DNI CON VALIDACIÓN MEJORADA -->
                <div class="form-group">
                    <label><i class="fas fa-id-card"></i> DNI * <span id="dni_contador" style="margin-left: 10px; font-size: 13px; font-weight: 600; color: #999;">(0/8)</span></label>
                    <div style="position: relative;">
                        <input type="text"
                               id="dni"
                               name="dni"
                               class="form-control"
                               placeholder="Ej: 75832984"
                               inputmode="numeric"
                               maxlength="8"
                               required
                               autocomplete="off"
                               value="{{ old('dni') }}"
                               style="padding-right: 40px; border: 2px solid #e0e0e0; transition: all 0.3s ease; font-weight: 500; letter-spacing: 1px;">
                        <span id="dni_icon" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); font-size: 20px; cursor: default;"></span>
                    </div>
                    <small class="form-text text-muted" id="dni_ayuda" style="display: block; margin-top: 6px;">
                        <i class="fas fa-info-circle"></i> Solo números. Presione Enter para buscar el paciente.
                    </small>
                </div>

                <!-- NOMBRE -->
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Nombre *</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre del paciente" required value="{{ old('nombre') }}">
                </div>

                <!-- APELLIDO -->
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Apellido *</label>
                    <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Apellido del paciente" required value="{{ old('apellido') }}">
                </div>

                <!-- CATEGORÍA (Área) -->
                <div class="form-group">
                    <label><i class="fas fa-layer-group"></i> Categoría / Área *</label>
                    <select id="categoria" name="categoria" class="form-control" required onchange="cargarCarreras()">
                        <option value="">-- Selecciona categoría --</option>
                        <option value="Tecnológico" {{ old('categoria') == 'Tecnológico' ? 'selected' : '' }}>Tecnológico</option>
                        <option value="Pedagógico" {{ old('categoria') == 'Pedagógico' ? 'selected' : '' }}>Pedagógico</option>
                        <option value="Escuela" {{ old('categoria') == 'Escuela' ? 'selected' : '' }}>Escuela</option>
                        <option value="Otros" {{ old('categoria') == 'Otros' ? 'selected' : '' }}>Otros</option>
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
                        <option value="INICIAL" {{ old('nivel_escuela') == 'INICIAL' ? 'selected' : '' }}>INICIAL</option>
                        <option value="PRIMARIA" {{ old('nivel_escuela') == 'PRIMARIA' ? 'selected' : '' }}>PRIMARIA</option>
                        <option value="SECUNDARIA" {{ old('nivel_escuela') == 'SECUNDARIA' ? 'selected' : '' }}>SECUNDARIA</option>
                    </select>
                </div>

                <!-- OTROS (Campo de texto libre) -->
                <div class="form-group" id="div_otros" style="display:none;">
                    <label><i class="fas fa-keyboard"></i> Especifique el área o cargo *</label>
                    <input type="text" id="otros_especificacion" name="otros_especificacion" class="form-control" placeholder="Ej: Docente de Contabilidad" value="{{ old('otros_especificacion') }}">
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
                    <input type="text" id="anios" name="anios" class="form-control" placeholder="Ej: 3 años, 4 años, 5 años" value="{{ old('anios') }}">
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
                    <input type="number" id="edad" name="edad" class="form-control" placeholder="Edad" min="1" max="120" required value="{{ old('edad') }}">
                </div>

            </div>

            <!-- BOTONES -->
            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Paciente
                </button>
                <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </div>
    </form>
</div>

<script>
    // ========================================================
    // FORMULARIO PACIENTES - IGUAL A ATENCIONES
    // ========================================================
    console.log('✅ Formulario Pacientes cargado');

    // ====== VALIDACIÓN AVANZADA DEL DNI ======
    const dniInput = document.getElementById('dni');
    const dniIcon = document.getElementById('dni_icon');
    const dniContador = document.getElementById('dni_contador');
    const dniAyuda = document.getElementById('dni_ayuda');

    if (dniInput) {
        // En tiempo real: Solo números y máximo 8 caracteres
        dniInput.addEventListener('input', function(e) {
            // Remover caracteres no numéricos
            this.value = this.value.replace(/[^0-9]/g, '');

            // Limitar a 8 caracteres
            if (this.value.length > 8) {
                this.value = this.value.slice(0, 8);
            }

            // Actualizar contador visual
            const longitud = this.value.length;
            dniContador.textContent = `(${longitud}/8)`;

            // Cambiar color de borde según validez
            if (longitud === 0) {
                dniInput.style.borderColor = '#e0e0e0';
                dniInput.style.boxShadow = 'none';
                dniIcon.textContent = '';
                dniIcon.style.color = '';
                dniAyuda.innerHTML = '<i class="fas fa-info-circle"></i> Solo números. Presione Enter para buscar el paciente.';
                dniAyuda.style.color = '#666';
            } else if (longitud < 8) {
                dniInput.style.borderColor = '#ff9800';
                dniInput.style.boxShadow = '0 0 5px rgba(255, 152, 0, 0.3)';
                dniIcon.textContent = '⏳';
                dniIcon.style.color = '#ff9800';
                dniAyuda.innerHTML = `<i class="fas fa-pen-alt"></i> Faltan ${8 - longitud} dígitos...`;
                dniAyuda.style.color = '#ff9800';
            } else if (longitud === 8) {
                dniInput.style.borderColor = '#4CAF50';
                dniInput.style.boxShadow = '0 0 8px rgba(76, 175, 80, 0.4)';
                dniIcon.textContent = '✓';
                dniIcon.style.color = '#4CAF50';
                dniAyuda.innerHTML = '<i class="fas fa-check-circle"></i> ¡DNI válido! Presione Enter para buscar.';
                dniAyuda.style.color = '#4CAF50';
                dniAyuda.style.fontWeight = '600';
            }
        });

        // Prevenir pegado de caracteres no válidos
        dniInput.addEventListener('paste', function(e) {
            e.preventDefault();
            const texto = (e.clipboardData || window.clipboardData).getData('text');
            const soloNumeros = texto.replace(/[^0-9]/g, '').slice(0, 8);
            this.value = soloNumeros;

            // Trigger input event para actualizar visual
            this.dispatchEvent(new Event('input'));
        });

        // Buscar paciente cuando completa 8 dígitos y presiona Enter
        dniInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && this.value.length === 8) {
                e.preventDefault();
                buscarPacientePorDNI();
            }
        });

        // Validar al perder foco
        dniInput.addEventListener('blur', function() {
            if (this.value.length === 8 && /^\d{8}$/.test(this.value)) {
                buscarPacientePorDNI();
            }
        });
    }

    // Función de búsqueda de paciente por DNI
    function buscarPacientePorDNI() {
        const dni = document.getElementById('dni').value;

        if (!dni || dni.length !== 8 || !/^\d{8}$/.test(dni)) {
            dniAyuda.innerHTML = '<i class="fas fa-exclamation-circle"></i> DNI debe tener exactamente 8 dígitos numéricos.';
            dniAyuda.style.color = '#c0392b';
            return;
        }

        // Mostrar estado de búsqueda
        dniIcon.textContent = '🔍';
        dniIcon.style.color = '#2196F3';
        dniAyuda.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Buscando paciente...';
        dniAyuda.style.color = '#2196F3';
        document.getElementById('nombre').value = 'Buscando...';
        document.getElementById('apellido').value = 'Buscando...';

        fetch(`/atenciones/buscar/${dni}`)
            .then(response => response.json())
            .then(data => {
                if (data.encontrado) {
                    document.getElementById('nombre').value = data.nombre;
                    document.getElementById('apellido').value = data.apellido;
                    document.getElementById('edad').value = data.edad || '';

                    dniIcon.textContent = '✓';
                    dniIcon.style.color = '#4CAF50';
                    dniAyuda.innerHTML = '<i class="fas fa-check-circle"></i> Paciente encontrado y datos completados.';
                    dniAyuda.style.color = '#4CAF50';

                    if (data.categoria) {
                        document.getElementById('categoria').value = data.categoria;
                        cargarCarreras();

                        setTimeout(() => {
                            if (data.carrera_id) {
                                document.getElementById('carrera_id').value = data.carrera_id;
                                actualizarCamposSegunCarrera();
                            }
                        }, 500);
                    }

                    if (data.otros_especificacion) {
                        document.getElementById('otros_especificacion').value = data.otros_especificacion;
                    }
                } else {
                    document.getElementById('nombre').value = '';
                    document.getElementById('apellido').value = '';
                    dniIcon.textContent = '?';
                    dniIcon.style.color = '#ff9800';
                    dniAyuda.innerHTML = '<i class="fas fa-user-plus"></i> Paciente no encontrado. Ingrese los datos manualmente.';
                    dniAyuda.style.color = '#ff9800';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('nombre').value = '';
                document.getElementById('apellido').value = '';
                dniIcon.textContent = '!';
                dniIcon.style.color = '#c0392b';
                dniAyuda.innerHTML = '<i class="fas fa-times-circle"></i> Error en la búsqueda. Intente nuevamente.';
                dniAyuda.style.color = '#c0392b';
            });
    }

    // Configuración de semestres por categoría
    const configuracion = {
        'Tecnológico': {
            semestres: ['I', 'II', 'III', 'IV', 'V', 'VI']
        },
        'Pedagógico': {
            semestres: ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X']
        }
    };

    // Cargar carreras dinámicamente según categoría
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
            // Si es "Otros", mostrar campo de texto libre
            divOtros.style.display = 'block';
        } else if (categoria === 'Escuela') {
            // Para "Escuela", mostrar select de nivel escuela (INICIAL/PRIMARIA/SECUNDARIA)
            divNivelEscuela.style.display = 'block';
        } else {
            // Para Tecnológico y Pedagógico: cargar carreras de la BD
            divCarrera.style.display = 'block';

            fetch(`/carreras/categoria/${categoria}`)
                .then(response => response.json())
                .then(data => {
                    carreraSelect.innerHTML = '<option value="">-- Selecciona una carrera --</option>';
                    data.forEach(carrera => {
                        const option = document.createElement('option');
                        option.value = carrera.id;
                        if (carrera.acronimo) {
                            option.textContent = `${carrera.nombre} (${carrera.acronimo})`;
                        } else {
                            option.textContent = carrera.nombre;
                        }
                        carreraSelect.appendChild(option);
                    });

                    // Mostrar semestre para Tecnológico y Pedagógico
                    divSemestre.style.display = 'block';
                    actualizarSemestres(categoria);
                })
                .catch(error => {
                    console.error('Error:', error);
                    carreraSelect.innerHTML = '<option value="">Error al cargar carreras</option>';
                });
        }
    }

    // Actualizar semestres según categoría
    function actualizarSemestres(categoria) {
        const semestreSelect = document.getElementById('semestre');
        semestreSelect.innerHTML = '<option value="">-- Selecciona semestre --</option>';

        if (configuracion[categoria] && configuracion[categoria].semestres) {
            configuracion[categoria].semestres.forEach(semestre => {
                const option = document.createElement('option');
                option.value = semestre;
                option.textContent = `Semestre ${semestre}`;
                semestreSelect.appendChild(option);
            });
        }
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

    // Actualizar grados según la carrera seleccionada (solo para Tecnológico y Pedagógico)
    function actualizarCamposSegunCarrera() {
        console.log('actualizarCamposSegunCarrera llamada');
    }

    // Validar antes de enviar
    document.getElementById('formPaciente').addEventListener('submit', function(e) {
        // Validar que DNI tenga exactamente 8 dígitos
        const dni = document.getElementById('dni').value;
        if (!dni || dni.length !== 8 || !/^\d{8}$/.test(dni)) {
            alert('Por favor ingrese un DNI válido con 8 dígitos numéricos');
            e.preventDefault();
            return;
        }

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

    // Restaurar campos si hay old() values
    window.addEventListener('load', function() {
        const categoriaOld = document.getElementById('categoria').value;
        if (categoriaOld) {
            cargarCarreras();
        }
    });
</script>
@endsection
