<?php

namespace Database\Seeders;

use App\Models\Proyecto;
use Illuminate\Database\Seeder;

class ProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proyectos = [
            [
                'codigo' => 'BICM',
                'nombre' => 'Oceanográfico',
                'descripcion' => 'Proyecto Oceanográfico',
            ],
            [
                'codigo' => 'BALC',
                'nombre' => 'Buque DA',
                'descripcion' => 'Proyecto Buque DA',
            ],
            [
                'codigo' => 'OPV',
                'nombre' => 'Offshore',
                'descripcion' => 'Proyecto Offshore',
            ],
            [
                'codigo' => 'BRF',
                'nombre' => 'Refluvial',
                'descripcion' => 'Proyecto Refluvial',
            ],
        ];

        foreach ($proyectos as $proyecto) {
            Proyecto::create($proyecto);
        }
    }
}
