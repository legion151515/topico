@extends('layouts.app')

@section('page_title', 'Nueva Atención Médica')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Registrar Nueva Atención</h2>
    </div>

    <form action="{{ route('atenciones.store') }}" method="POST" id="formAtencion">
        @csrf

        <div style="padding: 30px;">

            <!-- TIEMPO DE ATENCIÓN - PRIMERO Y OBLIGATORIO -->
            <h3 style="color: #1e3c72; margin-bottom: 20px; font-size: 16px; font-weight: 600; background: #fff3cd; padding: 15px; border-left: 4px solid #ff9800; border-radius: 4px;">
                <i class="fas fa-clock"></i> ⚠️ TIEMPO DE ATENCIÓN - OBLIGATORIO
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 20px; margin-bottom: 30px; background: #f8f9fa; padding: 20px; border-radius: 8px;">

                <div class="form-group">
                    <label style="font-weight: 700; color: #c0392b;"><i class="fas fa-calendar-alt"></i> Fecha *</label>
                    <input type="date" id="fecha" name="fecha" class="form-control" required style="border: 2px solid #4CAF50; padding: 12px;">
                </div>

                <div class="form-group">
                    <label style="font-weight: 700; color: #c0392b;"><i class="fas fa-sign-in-alt"></i> Hora Entrada *</label>
                    <input type="time" id="hora_entrada" name="hora_entrada" class="form-control" required style="border: 2px solid #4CAF50; padding: 12px;">
                </div>

                <div class="form-group">
                    <label style="font-weight: 700;"><i class="fas fa-sign-out-alt"></i> Hora Salida</label>
                    <input type="time" id="hora_salida" name="hora_salida" class="form-control" step="1" style="border: 1px solid #ddd; padding: 12px;">
                </div>

                <div class="form-group">
                    <label style="font-weight: 700;">Tipo de Registro Salida *</label>
                    <select id="tipo_salida" name="tipo_salida" class="form-control" required onchange="cambiarTipoSalida()">
                        <option value="">-- Selecciona --</option>
                        <option value="Manual">Manual (Digitaré la hora)</option>
                        <option value="Automático">Automática (Sistema registra)</option>
                    </select>
                </div>
            </div>

            <!-- INFORMACIÓN DEL PACIENTE -->
            <h3 style="color: #1e3c72; margin-bottom: 20px; font-size: 16px; font-weight: 600;">
                <i class="fas fa-user-injured"></i> Información del Paciente
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 30px; background: #f8f9fa; padding: 20px; border-radius: 8px;">

                <!-- DNI -->
                <div class="form-group">
                    <label><i class="fas fa-id-card"></i> DNI *</label>
                    <input type="text" id="dni" name="dni" class="form-control" placeholder="Ej: 75832984" required>
                    <small class="form-text text-muted">Ingrese DNI y presione Enter o Tab para buscar</small>
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

                <!-- CARRERA (Subnivel dinámico) -->
                <div class="form-group" id="div_carrera" style="display:none;">
                    <label><i class="fas fa-graduation-cap"></i> Carrera / Subnivel *</label>
                    <select id="carrera_id" name="carrera_id" class="form-control" onchange="actualizarCamposSegunCarrera()">
                        <option value="">-- Selecciona primero una categoría --</option>
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

                <!-- GRADO (Solo para Escuela) -->
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

            <!-- MOTIVO DE CONSULTA -->
            <h3 style="color: #1e3c72; margin-bottom: 20px; font-size: 16px; font-weight: 600;">
                <i class="fas fa-stethoscope"></i> Motivo de Consulta
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
                <div class="form-group">
                    <label>Selecciona el motivo *</label>
                    <select id="motivo_id" name="motivo_id" class="form-control" required onchange="mostrarMotivOtro()">
                        <option value="">-- Selecciona un motivo --</option>
                        @foreach($motivos as $motivo)
                            <option value="{{ $motivo->id }}">{{ $motivo->nombre }}</option>
                        @endforeach
                        <option value="0">Otros (especificar)</option>
                    </select>
                </div>

                <div class="form-group" id="div_motivo_otro" style="display:none;">
                    <label>Especifica el motivo</label>
                    <input type="text" id="motivo_otro" name="motivo_otro" class="form-control" placeholder="Describe el motivo de consulta">
                </div>
            </div>

            <!-- MEDICAMENTOS -->
            <h3 style="color: #1e3c72; margin-bottom: 20px; font-size: 16px; font-weight: 600;">
                <i class="fas fa-pills"></i> Medicamentos Utilizados
            </h3>

            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px;">
                @foreach($medicamentos as $med)
                    <div style="padding: 15px; background: white; border-radius: 6px; border-left: 4px solid #4CAF50;">
                        <div style="display: flex; align-items: flex-start; gap: 10px;">
                            <input type="checkbox" id="med_{{ $med->id }}" name="medicamentos[{{ $med->id }}]" value="{{ $med->id }}" onchange="toggleCantidad({{ $med->id }})">

                            <div style="flex: 1;">
                                <strong>{{ $med->nombre }}</strong><br>
                                <small style="color: #666;">Vencimiento: {{ $med->fecha_vencimiento }}</small><br>
                                @if($med->cantidad_stock < $med->stock_minimo_alerta)
                                    <span class="badge badge-danger">Stock bajo: {{ $med->cantidad_stock }}</span>
                                @else
                                    <span class="badge badge-info">Stock: {{ $med->cantidad_stock }}</span>
                                @endif
                            </div>
                        </div>

                        <input type="number" class="cantidad_input" id="cantidad_{{ $med->id }}" name="cantidad[{{ $med->id }}]" min="1" max="{{ $med->cantidad_stock }}" placeholder="Cantidad" disabled style="margin-top: 10px; width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                @endforeach
            </div>

            <!-- OBSERVACIONES -->
            <h3 style="color: #1e3c72; margin-bottom: 20px; font-size: 16px; font-weight: 600;">
                <i class="fas fa-clipboard"></i> Observaciones
            </h3>

            <div class="form-group">
                <textarea id="observaciones" name="observaciones" class="form-control" rows="4" placeholder="Notas sobre la atención..."></textarea>
            </div>

            <!-- BOTONES -->
            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Registrar Atención
                </button>
                <a href="{{ route('atenciones.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </div>
    </form>
</div>

<script>
    // Configuración de semestres y grados por categoría
    const configuracion = {
        'Tecnológico': {
            semestres: ['I', 'II', 'III', 'IV', 'V', 'VI']
        },
        'Pedagógico': {
            semestres: ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X']
        },
        'Escuela': {
            grados: {
                '3 años': null,
                '4 años': null,
                '5 años': null,
                '1° Primaria': '1°',
                '2° Primaria': '2°',
                '3° Primaria': '3°',
                '4° Primaria': '4°',
                '5° Primaria': '5°',
                '6° Primaria': '6°',
                '1° Secundaria': '1°',
                '2° Secundaria': '2°',
                '3° Secundaria': '3°',
                '4° Secundaria': '4°',
                '5° Secundaria': '5°'
            }
        }
    };

    // Cargar carreras dinámicamente según categoría
    function cargarCarreras() {
        const categoria = document.getElementById('categoria').value;
        const carreraSelect = document.getElementById('carrera_id');
        const divCarrera = document.getElementById('div_carrera');
        const divOtros = document.getElementById('div_otros');
        const divSemestre = document.getElementById('div_semestre');
        const divGrado = document.getElementById('div_grado');

        // Resetear todo
        carreraSelect.innerHTML = '<option value="">-- Cargando --</option>';
        divOtros.style.display = 'none';
        divSemestre.style.display = 'none';
        divGrado.style.display = 'none';

        if (!categoria) {
            divCarrera.style.display = 'none';
            return;
        }

        if (categoria === 'Otros') {
            // Si es "Otros", mostrar campo de texto libre
            divCarrera.style.display = 'none';
            divOtros.style.display = 'block';
        } else {
            // Para todas las demás categorías: cargar de la BD
            divCarrera.style.display = 'block';
            divOtros.style.display = 'none';

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

                    // Mostrar campos adicionales según categoría
                    if (categoria === 'Escuela') {
                        divGrado.style.display = 'block';
                    } else if (categoria === 'Tecnológico' || categoria === 'Pedagógico') {
                        divSemestre.style.display = 'block';
                        actualizarSemestres(categoria);
                    }
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

    // Actualizar grados según la carrera seleccionada (solo para Escuela)
    function actualizarCamposSegunCarrera() {
        const categoria = document.getElementById('categoria').value;

        if (categoria === 'Escuela') {
            const carreraSelect = document.getElementById('carrera_id');
            const carreraOption = carreraSelect.options[carreraSelect.selectedIndex];
            const carreraNombre = carreraOption.textContent.trim();

            const gradoSelect = document.getElementById('grado');
            gradoSelect.innerHTML = '<option value="">-- Selecciona grado --</option>';

            // Si la carrera es de tipo años (Inicial)
            if (carreraNombre.includes('años')) {
                document.getElementById('div_grado').style.display = 'none';
            } else if (carreraNombre.includes('Primaria')) {
                // Mostrar grados de primaria
                document.getElementById('div_grado').style.display = 'block';
                for (let i = 1; i <= 6; i++) {
                    const option = document.createElement('option');
                    option.value = `${i}°`;
                    option.textContent = `${i}°`;
                    gradoSelect.appendChild(option);
                }
            } else if (carreraNombre.includes('Secundaria')) {
                // Mostrar grados de secundaria
                document.getElementById('div_grado').style.display = 'block';
                for (let i = 1; i <= 5; i++) {
                    const option = document.createElement('option');
                    option.value = `${i}°`;
                    option.textContent = `${i}°`;
                    gradoSelect.appendChild(option);
                }
            }
        }
    }

    // Cambiar tipo de salida (manual o automática)
    function cambiarTipoSalida() {
        const tipo = document.getElementById('tipo_salida').value;
        const horaSalidaInput = document.getElementById('hora_salida');

        if (tipo === 'Automático') {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            horaSalidaInput.value = hours + ':' + minutes + ':' + seconds;
            horaSalidaInput.disabled = true;
            horaSalidaInput.style.background = '#f0f0f0';
        } else if (tipo === 'Manual') {
            horaSalidaInput.disabled = false;
            horaSalidaInput.style.background = 'white';
            horaSalidaInput.value = '';
        }
    }

    // Mostrar campo de motivo otro
    function mostrarMotivOtro() {
        const motivo = document.getElementById('motivo_id').value;
        const div = document.getElementById('div_motivo_otro');
        if (motivo === '0') {
            div.style.display = 'block';
        } else {
            div.style.display = 'none';
        }
    }

    // Habilitar/Deshabilitar campo de cantidad
    function toggleCantidad(medId) {
        const checkbox = document.getElementById('med_' + medId);
        const input = document.getElementById('cantidad_' + medId);
        input.disabled = !checkbox.checked;
        if (checkbox.checked) {
            input.focus();
        }
    }

    // Llenar hora entrada automáticamente
    window.addEventListener('load', function() {
        // Llenar fecha hoy automáticamente
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('fecha').value = today;

        // Llenar hora entrada automáticamente
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        document.getElementById('hora_entrada').value = hours + ':' + minutes;
    });

    // Validar antes de enviar
    document.getElementById('formAtencion').addEventListener('submit', function(e) {
        // CRÍTICO: Habilitar todos los inputs de cantidad antes de enviar
        document.querySelectorAll('.cantidad_input').forEach(input => {
            if (input.value && input.value > 0) {
                input.disabled = false;
            }
        });

        const tipoSalida = document.getElementById('tipo_salida').value;
        const horaSalida = document.getElementById('hora_salida').value;
        const categoria = document.getElementById('categoria').value;
        const carreraId = document.getElementById('carrera_id').value;
        const grado = document.getElementById('grado').value;
        const semestre = document.getElementById('semestre').value;
        const otrosEspecificacion = document.getElementById('otros_especificacion').value;

        if (!tipoSalida) {
            alert('Por favor selecciona el tipo de registro de salida');
            e.preventDefault();
            return;
        }

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
        } else {
            if (!carreraId) {
                alert('Por favor selecciona una carrera');
                e.preventDefault();
                return;
            }

            if (categoria === 'Tecnológico' || categoria === 'Pedagógico') {
                if (!semestre) {
                    alert('Por favor selecciona un semestre');
                    e.preventDefault();
                    return;
                }
            }
        }
    });

    // AUTO-COMPLETADO AL BUSCAR POR DNI
    const dniInput = document.getElementById('dni');
    if (dniInput) {
        dniInput.addEventListener('blur', function() {
            buscarPacientePorDNI();
        });

        dniInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                buscarPacientePorDNI();
            }
        });
    }

    function buscarPacientePorDNI() {
        const dni = document.getElementById('dni').value;

        if (!dni || dni.length < 8) {
            return;
        }

        document.getElementById('nombre').value = 'Buscando...';
        document.getElementById('apellido').value = 'Buscando...';

        fetch(`/atenciones/buscar/${dni}`)
            .then(response => response.json())
            .then(data => {
                if (data.encontrado) {
                    document.getElementById('nombre').value = data.nombre;
                    document.getElementById('apellido').value = data.apellido;
                    document.getElementById('edad').value = data.edad || '';

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
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('nombre').value = '';
                document.getElementById('apellido').value = '';
            });
    }
</script>
@endsection
