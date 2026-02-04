<?php

namespace Database\Seeders;

use App\Models\Bloque;
use App\Models\Proyecto;
use Illuminate\Database\Seeder;

class BloqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Datos según Tabla 2 del documento
        $bloques = [
            ['nombre_bloque' => '1110', 'proyecto_codigo' => 'BICM'],
            ['nombre_bloque' => '2210', 'proyecto_codigo' => 'BALC'],
            ['nombre_bloque' => '3510', 'proyecto_codigo' => 'BICM'],
            ['nombre_bloque' => '3610', 'proyecto_codigo' => 'BICM'],
            ['nombre_bloque' => '3310', 'proyecto_codigo' => 'BALC'],
            ['nombre_bloque' => '2210', 'proyecto_codigo' => 'OPV'],
        ];

        foreach ($bloques as $bloqueData) {
            $proyecto = Proyecto::where('codigo', $bloqueData['proyecto_codigo'])->first();
            
            if ($proyecto) {
                Bloque::create([
                    'nombre_bloque' => $bloqueData['nombre_bloque'],
                    'proyecto_id' => $proyecto->id,
                    'descripcion' => "Bloque {$bloqueData['nombre_bloque']} del proyecto {$proyecto->nombre}",
                ]);
            }
        }
    }
}
