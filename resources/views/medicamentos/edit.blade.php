@extends('layouts.app')

@section('page_title', 'Editar Medicamento')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Editar Medicamento</h2>
    </div>

    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('medicamentos.update', $medicamento) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre del Medicamento *</label>
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                               value="{{ old('nombre', $medicamento->nombre) }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha de Vencimiento</label>
                        <input type="date" name="fecha_vencimiento"
                               class="form-control @error('fecha_vencimiento') is-invalid @enderror"
                               value="{{ old('fecha_vencimiento', $medicamento->fecha_vencimiento) }}">
                        @error('fecha_vencimiento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Descripción</label>
                <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                          rows="3">{{ old('descripcion', $medicamento->descripcion) }}</textarea>
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Indicaciones, presentación, etc.</small>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Cantidad en Stock *</label>
                        <input type="number" name="cantidad_stock"
                               class="form-control @error('cantidad_stock') is-invalid @enderror"
                               value="{{ old('cantidad_stock', $medicamento->cantidad_stock) }}" min="0" required>
                        @error('cantidad_stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Stock Mínimo de Alerta *</label>
                        <input type="number" name="stock_minimo_alerta"
                               class="form-control @error('stock_minimo_alerta') is-invalid @enderror"
                               value="{{ old('stock_minimo_alerta', $medicamento->stock_minimo_alerta) }}" min="0" required>
                        @error('stock_minimo_alerta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Se alertará cuando el stock esté por debajo de este valor</small>
                    </div>
                </div>
            </div>

            <hr>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Actualizar Medicamento
            </button>
            <a href="{{ route('medicamentos.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </form>
    </div>
</div>
@endsection
