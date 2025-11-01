@extends('layouts.app')

@section('page_title', 'Reportes - Atenciones por Área')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Atenciones por Área</h3>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Carrera</th>
                    <th>Total Atenciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($areas as $carrera => $total)
                    <tr>
                        <td>{{ $carrera }}</td>
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