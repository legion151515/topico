<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AtencionController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\MotivoConsultaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\ImportarPacienteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarreraController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rutas especiales ANTES de resource routes
    Route::get('/atenciones/buscar/{dni}', [AtencionController::class, 'buscarPaciente']);
    Route::get('/carreras/categoria/{categoria}', [CarreraController::class, 'obtenerPorCategoria'])->name('carreras.porCategoria');

    // Importar Pacientes
    Route::get('/pacientes/importar', [ImportarPacienteController::class, 'index'])->name('pacientes.importar');
    Route::post('/pacientes/importar/procesar', [ImportarPacienteController::class, 'importar'])->name('pacientes.importar.procesar');
    Route::get('/pacientes/plantilla/descargar', [ImportarPacienteController::class, 'descargarPlantilla'])->name('pacientes.plantilla');

    // Resource routes
    Route::resource('carreras', CarreraController::class);
    Route::resource('atenciones', AtencionController::class);
    Route::resource('pacientes', PacienteController::class);
    Route::resource('medicamentos', MedicamentoController::class);
    Route::resource('motivos', MotivoConsultaController::class);

    // Historial Clínico
    Route::get('/historial', [HistorialController::class, 'index'])->name('historial.index');
    Route::post('/historial/buscar', [HistorialController::class, 'buscar'])->name('historial.buscar');
    Route::get('/historial/pdf/{paciente}', [HistorialController::class, 'generarPDF'])->name('historial.pdf');

    // Reportes
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/area', [ReporteController::class, 'area'])->name('reportes.area');
    Route::get('/reportes/area/pdf', [ReporteController::class, 'areaPDF'])->name('reportes.area.pdf');
    Route::get('/reportes/enfermedad', [ReporteController::class, 'enfermedad'])->name('reportes.enfermedad');
    Route::get('/reportes/enfermedad/pdf', [ReporteController::class, 'enfermedadPDF'])->name('reportes.enfermedad.pdf');
    Route::get('/reportes/stock', [ReporteController::class, 'stock'])->name('reportes.stock');
    Route::get('/reportes/stock/pdf', [ReporteController::class, 'stockPDF'])->name('reportes.stock.pdf');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';