@extends('layouts.app')

@section('page_title', 'Reportes - Stock Bajo')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Medicamentos con Stock Bajo</h3>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Medicamento</th>
                    <th>Stock Actual</th>
                    <th>Stock Mínimo</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($medicamentos as $medicamento)
                    <tr>
                        <td>{{ $medicamento->nombre }}</td>
                        <td>{{ $medicamento->cantidad_stock }}</td>
                        <td>{{ $medicamento->stock_minimo_alerta }}</td>
                        <td>
                            @if($medicamento->cantidad_stock < $medicamento->stock_minimo_alerta)
                                <span class="badge badge-danger">Bajo</span>
                            @else
                                <span class="badge badge-success">Ok</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No hay medicamentos con stock bajo</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection