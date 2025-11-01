@extends('layouts.app')

@section('page_title', 'Reportes - Enfermedades Comunes')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Enfermedades Comunes</h3>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Motivo de Consulta</th>
                    <th>Total de Casos</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enfermedades as $enfermedad => $total)
                    <tr>
                        <td>{{ $enfermedad }}</td>
                        <td>{{ $total }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">No hay datos</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection