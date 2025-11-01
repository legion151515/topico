@extends('layouts.app')

@section('page_title', 'Detalle de Carrera')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Información de la Carrera</h2>
        <a href="{{ route('carreras.index') }}" class="btn btn-secondary float-right">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Categoría:</th>
                        <td><span class="badge badge-info">{{ $carrera->categoria }}</span></td>
                    </tr>
                    <tr>
                        <th>Nombre:</th>
                        <td><strong>{{ $carrera->nombre }}</strong></td>
                    </tr>
                    <tr>
                        <th>Acrónimo:</th>
                        <td><strong>{{ $carrera->acronimo }}</strong></td>
                    </tr>
                    <tr>
                        <th>Fecha de Registro:</th>
                        <td>{{ $carrera->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>

                <div class="mt-3">
                    <a href="{{ route('carreras.edit', $carrera) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                </div>
            </div>

            <div class="col-md-6">
                <h4>Estadísticas</h4>
                <div class="card bg-light">
                    <div class="card-body">
                        <h3 class="text-center">{{ $carrera->pacientes->count() }}</h3>
                        <p class="text-center mb-0">Pacientes Registrados</p>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <h4>Pacientes de esta Carrera</h4>

        @if($carrera->pacientes->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>DNI</th>
                            <th>Nombre Completo</th>
                            <th>Edad</th>
                            <th>Atenciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carrera->pacientes->sortBy('apellido') as $paciente)
                            <tr>
                                <td><strong>{{ $paciente->dni }}</strong></td>
                                <td>{{ $paciente->nombre }} {{ $paciente->apellido }}</td>
                                <td>{{ $paciente->edad }} años</td>
                                <td>
                                    <span class="badge badge-primary">{{ $paciente->atenciones->count() }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('pacientes.show', $paciente) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                No hay pacientes registrados en esta carrera aún.
            </div>
        @endif
    </div>
</div>
@endsection
