<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\Medicamento::create([
        'nombre' => 'Paracetamol 500mg',
        'descripcion' => 'Analgésico y antipirético',
        'cantidad_stock' => 100,
        'stock_minimo_alerta' => 10,
        'fecha_vencimiento' => '2026-12-31'
    ]);
    
    \App\Models\Medicamento::create([
        'nombre' => 'Ibuprofeno 400mg',
        'descripcion' => 'Antiinflamatorio',
        'cantidad_stock' => 80,
        'stock_minimo_alerta' => 10,
        'fecha_vencimiento' => '2026-11-30'
    ]);
    
    \App\Models\Medicamento::create([
        'nombre' => 'Amoxicilina 500mg',
        'descripcion' => 'Antibiótico',
        'cantidad_stock' => 50,
        'stock_minimo_alerta' => 15,
        'fecha_vencimiento' => '2025-12-15'
    ]);
    
    \App\Models\Medicamento::create([
        'nombre' => 'Antidiarreico',
        'descripcion' => 'Para diarrea',
        'cantidad_stock' => 30,
        'stock_minimo_alerta' => 8,
        'fecha_vencimiento' => '2026-08-30'
    ]);
    
    \App\Models\Medicamento::create([
        'nombre' => 'Vitamina C 500mg',
        'descripcion' => 'Suplemento vitamínico',
        'cantidad_stock' => 120,
        'stock_minimo_alerta' => 20,
        'fecha_vencimiento' => '2027-06-30'
    ]);
}
}
