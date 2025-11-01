@extends('layouts.app')

@section('page_title', 'Historial Clínico')

@section('content')
<div class="card">
    <div class="card-header">
        <h2><i class="fas fa-file-medical-alt"></i> Historial Clínico del Paciente</h2>
    </div>

    <div class="card-body">
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h4><i class="fas fa-search"></i> Buscar Paciente</h4>
                        <p class="text-muted">Ingrese el DNI del paciente para ver su historial clínico completo.</p>

                        <form action="{{ route('historial.buscar') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="dni">DNI del Paciente *</label>
                                <input type="text"
                                       name="dni"
                                       id="dni"
                                       class="form-control @error('dni') is-invalid @enderror"
                                       placeholder="Ej: 12345678"
                                       required
                                       autofocus
                                       maxlength="20">
                                @error('dni')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Buscar Historial
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="alert alert-info">
                    <h5><i class="fas fa-info-circle"></i> Información</h5>
                    <p class="mb-0">El historial clínico muestra todas las atenciones del paciente, incluyendo:</p>
                    <ul>
                        <li>Fechas y horas de atención</li>
                        <li>Motivos de consulta</li>
                        <li>Medicamentos administrados</li>
                        <li>Observaciones médicas</li>
                    </ul>
                    <p class="mt-2 mb-0">
                        <strong>Nota:</strong> Puede generar un reporte en PDF para que el paciente se lo pueda llevar.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #dni {
        font-size: 18px;
        padding: 15px;
    }
</style>

<script>
    // Auto-focus en el campo DNI
    document.getElementById('dni').focus();

    // Solo permitir números en el campo DNI
    document.getElementById('dni').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
@endsection
