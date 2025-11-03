<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Nivel;

class NivelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveles = [
            [
                'nombre' => 'INICIAL',
                'acronimo' => 'INI',
                'tipo' => 'Escuela'
            ],
            [
                'nombre' => 'PRIMARIA',
                'acronimo' => 'PRI',
                'tipo' => 'Escuela'
            ],
            [
                'nombre' => 'SECUNDARIA',
                'acronimo' => 'SEC',
                'tipo' => 'Escuela'
            ],
            [
                'nombre' => 'OTROS',
                'acronimo' => 'OTR',
                'tipo' => 'Otros'
            ]
        ];

        foreach ($niveles as $nivel) {
            Nivel::create($nivel);
        }
    }
}
