<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Carrera;

class CarreraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // TECNOLÓGICO
        Carrera::create(['categoria' => 'Tecnológico', 'nombre' => 'Sistemas de Información', 'acronimo' => 'SI']);
        Carrera::create(['categoria' => 'Tecnológico', 'nombre' => 'Administración de Datos', 'acronimo' => 'AD']);
        Carrera::create(['categoria' => 'Tecnológico', 'nombre' => 'Electrónica', 'acronimo' => 'ELE']);
        Carrera::create(['categoria' => 'Tecnológico', 'nombre' => 'Telecomunicaciones', 'acronimo' => 'TEL']);

        // PEDAGÓGICO
        Carrera::create(['categoria' => 'Pedagógico', 'nombre' => 'Educación Inicial', 'acronimo' => 'EI']);
        Carrera::create(['categoria' => 'Pedagógico', 'nombre' => 'Educación Primaria', 'acronimo' => 'EP']);
        Carrera::create(['categoria' => 'Pedagógico', 'nombre' => 'Educación Secundaria', 'acronimo' => 'ES']);
        Carrera::create(['categoria' => 'Pedagógico', 'nombre' => 'Educación Física', 'acronimo' => 'EF']);

        // ESCUELA (Grados escolares - subniveles dinámicos)
        Carrera::create(['categoria' => 'Escuela', 'nombre' => 'Inicial', 'acronimo' => 'INI']);
        Carrera::create(['categoria' => 'Escuela', 'nombre' => 'Primaria', 'acronimo' => 'PRI']);
        Carrera::create(['categoria' => 'Escuela', 'nombre' => 'Secundaria', 'acronimo' => 'SEC']);
    }
}