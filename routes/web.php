<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AtencionController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\ReporteController;
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

    // Resource routes
    Route::resource('carreras', CarreraController::class);
    Route::resource('atenciones', AtencionController::class);
    Route::resource('pacientes', PacienteController::class);
    Route::resource('medicamentos', MedicamentoController::class);

    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/area', [ReporteController::class, 'area'])->name('reportes.area');
    Route::get('/reportes/enfermedad', [ReporteController::class, 'enfermedad'])->name('reportes.enfermedad');
    Route::get('/reportes/stock', [ReporteController::class, 'stock'])->name('reportes.stock');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';