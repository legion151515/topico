<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MotivoConsultaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\MotivoConsulta::create(['nombre' => 'Dolor de cabeza', 'descripcion' => 'Cefalea']);
    \App\Models\MotivoConsulta::create(['nombre' => 'Fiebre', 'descripcion' => 'Temperatura elevada']);
    \App\Models\MotivoConsulta::create(['nombre' => 'Gripe', 'descripcion' => 'Síntomas gripales']);
    \App\Models\MotivoConsulta::create(['nombre' => 'Malestar general', 'descripcion' => 'Malestar general']);
    \App\Models\MotivoConsulta::create(['nombre' => 'Nauseas', 'descripcion' => 'Náuseas y mareos']);
    \App\Models\MotivoConsulta::create(['nombre' => 'Herida leve', 'descripcion' => 'Herida o corte leve']);
    \App\Models\MotivoConsulta::create(['nombre' => 'Mareos', 'descripcion' => 'Mareos y vértigo']);
    \App\Models\MotivoConsulta::create(['nombre' => 'Tos leve', 'descripcion' => 'Tos seca o con flemas']);
    \App\Models\MotivoConsulta::create(['nombre' => 'Dolor abdominal', 'descripcion' => 'Dolor en el abdomen']);
    \App\Models\MotivoConsulta::create(['nombre' => 'Revisión general', 'descripcion' => 'Revisión médica general']);
}
}
