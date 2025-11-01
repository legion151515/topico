@extends('layouts.app')

@section('page_title', 'Editar Atención')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Editar Atención</h2>
    </div>

    <form action="{{ route('atenciones.update', $atencion->id) }}" method="POST" id="formAtencion">
        @csrf @method('PUT')

        <div style="padding: 30px;">
            
            <!-- TIEMPO DE ATENCIÓN -->
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
                    <input type="time" id="hora_salida" name="hora_salida" class="form-control" style="border: 1px solid #ddd; padding: 12px;">
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
                
                <div class="form-group">
                    <label><i class="fas fa-id-card"></i> DNI *</label>
                    <input type="text" id="dni" name="dni" class="form-control" placeholder="Ej: 75832984" required>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-user"></i> Nombre *</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre del paciente" required>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-user"></i> Apellido *</label>
                    <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Apellido del paciente" required>
                </div>

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

                <div class="form-group" id="div_carrera" style="display:none;">
                    <label><i class="fas fa-graduation-cap"></i> Carrera / Subnivel *</label>
                    <select id="carrera_id" name="carrera_id" class="form-control" onchange="actualizarCamposSegunCarrera()">
                        <option value="">-- Selecciona primero una categoría --</option>
                    </select>
                </div>

                <div class="form-group" id="div_otros" style="display:none;">
                    <label><i class="fas fa-keyboard"></i> Especifique el área o cargo *</label>
                    <input type="text" id="otros_especificacion" name="otros_especificacion" class="form-control" placeholder="Ej: Docente de Contabilidad">
                </div>

                <div class="form-group" id="div_semestre" style="display:none;">
                    <label><i class="fas fa-book"></i> Semestre *</label>
                    <select id="semestre" name="semestre" class="form-control">
                        <option value="">-- Selecciona semestre --</option>
                    </select>
                </div>

                <div class="form-group" id="div_grado" style="display:none;">
                    <label><i class="fas fa-book"></i> Grado *</label>
                    <select id="grado" name="grado" class="form-control">
                        <option value="">-- Selecciona grado --</option>
                    </select>
                </div>

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
                    <i class="fas fa-save"></i> Actualizar Atención
                </button>
                <a href="{{ route('atenciones.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </div>
    </form>
</div>

<!-- DATOS DIRECTOS DE LA BASE DE DATOS COMO JSON -->
<script>
    const datosAtencion = {!! json_encode([
        'id' => $atencion->id,
        'fecha' => $atencion->fecha,
        'hora_entrada' => $atencion->hora_entrada,
        'hora_salida' => $atencion->hora_salida,
        'tipo_salida' => $atencion->tipo_salida,
        'dni' => $atencion->paciente->dni ?? '',
        'nombre' => $atencion->paciente->nombre ?? '',
        'apellido' => $atencion->paciente->apellido ?? '',
        'categoria' => $atencion->paciente->categoria ?? '',
        'carrera_id' => $atencion->paciente->carrera_id ?? '',
        'otros_especificacion' => $atencion->paciente->otros_especificacion ?? '',
        'semestre' => $atencion->paciente->semestre ?? '',
        'grado' => $atencion->paciente->grado ?? '',
        'edad' => $atencion->paciente->edad ?? '',
        'motivo_id' => $atencion->motivo_id ?? '',
        'motivo_otro' => $atencion->motivo_otro ?? '',
        'observaciones' => $atencion->observaciones ?? '',
        'medicamentos' => $atencion->medicamentos->map(function($m) {
            return [
                'id' => $m->id,
                'cantidad' => $m->pivot->cantidad ?? 0
            ];
        })->toArray()
    ]) !!};

    console.log('Datos cargados:', datosAtencion);

    // Configuración de semestres y grados
    const configuracion = {
        'Tecnológico': {
            semestres: ['I', 'II', 'III', 'IV', 'V', 'VI']
        },
        'Pedagógico': {
            semestres: ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X']
        },
        'Escuela': {
            grados: {
                'Inicial': null,
                'Primaria': ['1°', '2°', '3°', '4°', '5°', '6°'],
                'Secundaria': ['1°', '2°', '3°', '4°', '5°']
            }
        },
        'Otros': {}
    };

    // AL CARGAR LA PÁGINA
    window.addEventListener('load', function() {
        console.log('Iniciando carga de datos...');
        
        // LLENAR TODOS LOS CAMPOS CON LOS DATOS DE LA BD
        document.getElementById('fecha').value = datosAtencion.fecha || '';
        document.getElementById('hora_entrada').value = datosAtencion.hora_entrada || '';
        document.getElementById('hora_salida').value = datosAtencion.hora_salida || '';
        document.getElementById('tipo_salida').value = datosAtencion.tipo_salida || '';
        document.getElementById('dni').value = datosAtencion.dni || '';
        document.getElementById('nombre').value = datosAtencion.nombre || '';
        document.getElementById('apellido').value = datosAtencion.apellido || '';
        document.getElementById('edad').value = datosAtencion.edad || '';
        document.getElementById('motivo_id').value = datosAtencion.motivo_id || '';
        document.getElementById('motivo_otro').value = datosAtencion.motivo_otro || '';
        document.getElementById('observaciones').value = datosAtencion.observaciones || '';
        
        console.log('Categoría de BD:', datosAtencion.categoria);
        
        // ESTABLECER CATEGORÍA
        document.getElementById('categoria').value = datosAtencion.categoria || '';
        
        // SI TIENE CATEGORÍA, CARGAR CARRERAS
        if (datosAtencion.categoria) {
            setTimeout(() => {
                cargarCarrerasInit();
            }, 300);
        }
        
        // MOSTRAR MOTIVO OTRO SI CORRESPONDE
        mostrarMotivOtro();
        
        // RESTAURAR MEDICAMENTOS
        if (datosAtencion.medicamentos && datosAtencion.medicamentos.length > 0) {
            datosAtencion.medicamentos.forEach(med => {
                const checkbox = document.getElementById('med_' + med.id);
                const cantidad = document.getElementById('cantidad_' + med.id);
                if (checkbox) {
                    checkbox.checked = true;
                    if (cantidad) {
                        cantidad.disabled = false;
                        cantidad.value = med.cantidad || '';
                    }
                }
            });
        }
    });

    function cargarCarrerasInit() {
        const categoria = datosAtencion.categoria;
        const carreraSelect = document.getElementById('carrera_id');
        const divCarrera = document.getElementById('div_carrera');
        const divOtros = document.getElementById('div_otros');
        const divSemestre = document.getElementById('div_semestre');
        const divGrado = document.getElementById('div_grado');

        if (categoria === 'Otros') {
            divCarrera.style.display = 'none';
            divOtros.style.display = 'block';
            divSemestre.style.display = 'none';
            divGrado.style.display = 'none';
        } else {
            divCarrera.style.display = 'block';
            divOtros.style.display = 'none';
            
            if (categoria === 'Escuela') {
                divGrado.style.display = 'block';
                divSemestre.style.display = 'none';
            } else {
                divSemestre.style.display = 'block';
                divGrado.style.display = 'none';
            }

            fetch(`/carreras/${categoria}`)
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
                    if (datosAtencion.carrera_id) {
                        carreraSelect.value = datosAtencion.carrera_id;
                        console.log('Carrera seleccionada:', datosAtencion.carrera_id);
                        actualizarCamposSegunCarrera();
                    }

                    // LLENAR SEMESTRES
                    if (categoria !== 'Escuela' && configuracion[categoria].semestres) {
                        const semestreSelect = document.getElementById('semestre');
                        semestreSelect.innerHTML = '<option value="">-- Selecciona semestre --</option>';
                        configuracion[categoria].semestres.forEach(semestre => {
                            const option = document.createElement('option');
                            option.value = semestre;
                            option.textContent = `Semestre ${semestre}`;
                            semestreSelect.appendChild(option);
                        });
                        if (datosAtencion.semestre) {
                            semestreSelect.value = datosAtencion.semestre;
                            console.log('Semestre seleccionado:', datosAtencion.semestre);
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
        const divOtros = document.getElementById('div_otros');
        const divSemestre = document.getElementById('div_semestre');
        const divGrado = document.getElementById('div_grado');

        carreraSelect.innerHTML = '<option value="">-- Cargando --</option>';
        divOtros.style.display = 'none';
        divSemestre.style.display = 'none';
        divGrado.style.display = 'none';

        if (!categoria) {
            divCarrera.style.display = 'none';
            return;
        }

        if (categoria === 'Otros') {
            divCarrera.style.display = 'none';
            divOtros.style.display = 'block';
        } else {
            divCarrera.style.display = 'block';
            fetch(`/carreras/${categoria}`)
                .then(response => response.json())
                .then(data => {
                    carreraSelect.innerHTML = '<option value="">-- Selecciona una carrera --</option>';
                    data.forEach(carrera => {
                        const option = document.createElement('option');
                        option.value = carrera.id;
                        option.textContent = `${carrera.nombre} (${carrera.acronimo})`;
                        carreraSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error:', error));

            if (categoria === 'Escuela') {
                divGrado.style.display = 'block';
            } else {
                divSemestre.style.display = 'block';
                if (configuracion[categoria].semestres) {
                    const semestreSelect = document.getElementById('semestre');
                    semestreSelect.innerHTML = '<option value="">-- Selecciona semestre --</option>';
                    configuracion[categoria].semestres.forEach(semestre => {
                        const option = document.createElement('option');
                        option.value = semestre;
                        option.textContent = `Semestre ${semestre}`;
                        semestreSelect.appendChild(option);
                    });
                }
            }
        }
    }

    function actualizarCamposSegunCarrera() {
        const categoria = document.getElementById('categoria').value;
        
        if (categoria === 'Escuela') {
            const carreraSelect = document.getElementById('carrera_id');
            const carreraOption = carreraSelect.options[carreraSelect.selectedIndex];
            const carreraNombre = carreraOption.textContent.split('(')[0].trim();

            const gradoSelect = document.getElementById('grado');
            gradoSelect.innerHTML = '<option value="">-- Selecciona grado --</option>';

            const grados = configuracion['Escuela'].grados[carreraNombre];

            if (grados === null) {
                document.getElementById('div_grado').style.display = 'none';
            } else if (grados) {
                document.getElementById('div_grado').style.display = 'block';
                grados.forEach(grado => {
                    const option = document.createElement('option');
                    option.value = grado;
                    option.textContent = grado;
                    gradoSelect.appendChild(option);
                });
                if (datosAtencion.grado) {
                    gradoSelect.value = datosAtencion.grado;
                    console.log('Grado seleccionado:', datosAtencion.grado);
                }
            }
        }
    }

    function cambiarTipoSalida() {
        const tipo = document.getElementById('tipo_salida').value;
        const horaSalidaInput = document.getElementById('hora_salida');
        
        if (tipo === 'Automático') {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            horaSalidaInput.value = hours + ':' + minutes;
            horaSalidaInput.disabled = true;
            horaSalidaInput.style.background = '#f0f0f0';
        } else if (tipo === 'Manual') {
            horaSalidaInput.disabled = false;
            horaSalidaInput.style.background = 'white';
        }
    }

    function mostrarMotivOtro() {
        const motivo = document.getElementById('motivo_id').value;
        const div = document.getElementById('div_motivo_otro');
        if (motivo === '0') {
            div.style.display = 'block';
        } else {
            div.style.display = 'none';
        }
    }

    function toggleCantidad(medId) {
        const checkbox = document.getElementById('med_' + medId);
        const input = document.getElementById('cantidad_' + medId);
        input.disabled = !checkbox.checked;
        if (checkbox.checked) {
            input.focus();
        }
    }

    // VALIDACIÓN AL ENVIAR
    document.getElementById('formAtencion').addEventListener('submit', function(e) {
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

        if (tipoSalida === 'Manual' && !horaSalida) {
            alert('Por favor ingresa la hora de salida');
            e.preventDefault();
            return;
        }

        if (!categoria) {
            alert('Por favor selecciona una categoría');
            e.preventDefault();
            return;
        }

        if (categoria === 'Otros' && !otrosEspecificacion) {
            alert('Por favor especifica el área o cargo');
            e.preventDefault();
            return;
        }

        if (categoria === 'Escuela') {
            if (!carreraId) {
                alert('Por favor selecciona un nivel escolar');
                e.preventDefault();
                return;
            }
        } else if (categoria !== 'Otros') {
            if (!carreraId) {
                alert('Por favor selecciona una carrera');
                e.preventDefault();
                return;
            }
            if (!semestre) {
                alert('Por favor selecciona un semestre');
                e.preventDefault();
                return;
            }
        }
    });
</script>
@endsection