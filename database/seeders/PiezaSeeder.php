<?php

namespace Database\Seeders;

use App\Models\Bloque;
use App\Models\Pieza;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Database\Seeder;

class PiezaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Datos según Tabla 4 y 5 del documento
        $piezasData = [
            ['pieza' => 'B01', 'peso_teorico' => 4.5, 'peso_real' => 4.5, 'estado' => 'Fabricado', 'proyecto_codigo' => 'BALC', 'bloque_nombre' => '2210', 'fecha' => '2020-11-09', 'usuario' => 'Gabriel'],
            ['pieza' => 'A02', 'peso_teorico' => 20, 'peso_real' => null, 'estado' => 'Pendiente', 'proyecto_codigo' => 'BALC', 'bloque_nombre' => '3310', 'fecha' => null, 'usuario' => null],
            ['pieza' => 'H12', 'peso_teorico' => 16.6, 'peso_real' => 16.6, 'estado' => 'Fabricado', 'proyecto_codigo' => 'OPV', 'bloque_nombre' => '2210', 'fecha' => '2020-11-09', 'usuario' => 'Sergio'],
            ['pieza' => 'R23', 'peso_teorico' => 8, 'peso_real' => null, 'estado' => 'Pendiente', 'proyecto_codigo' => 'BICM', 'bloque_nombre' => '1110', 'fecha' => null, 'usuario' => null],
            ['pieza' => 'J25', 'peso_teorico' => 11, 'peso_real' => null, 'estado' => 'Pendiente', 'proyecto_codigo' => 'BICM', 'bloque_nombre' => '1110', 'fecha' => null, 'usuario' => null],
            ['pieza' => 'U23', 'peso_teorico' => 4, 'peso_real' => 4, 'estado' => 'Fabricado', 'proyecto_codigo' => 'BICM', 'bloque_nombre' => '1110', 'fecha' => '2020-11-09', 'usuario' => 'Sergio'],
            ['pieza' => 'E29', 'peso_teorico' => 7.2, 'peso_real' => 7.2, 'estado' => 'Fabricado', 'proyecto_codigo' => 'BICM', 'bloque_nombre' => '1110', 'fecha' => '2020-11-09', 'usuario' => 'Luis'],
            ['pieza' => 'E21', 'peso_teorico' => 18, 'peso_real' => null, 'estado' => 'Pendiente', 'proyecto_codigo' => 'BICM', 'bloque_nombre' => '3510', 'fecha' => null, 'usuario' => null],
        ];

        foreach ($piezasData as $piezaData) {
            $proyecto = Proyecto::where('codigo', $piezaData['proyecto_codigo'])->first();
            $bloque = Bloque::where('nombre_bloque', $piezaData['bloque_nombre'])
                ->where('proyecto_id', $proyecto->id)
                ->first();
            
            // Obtener usuario si existe
            $usuario = null;
            if ($piezaData['usuario']) {
                $usuario = User::where('name', $piezaData['usuario'])->first();
            }
            
            if ($proyecto && $bloque) {
                Pieza::create([
                    'pieza' => $piezaData['pieza'],
                    'peso_teorico' => $piezaData['peso_teorico'],
                    'peso_real' => $piezaData['peso_real'],
                    'estado' => $piezaData['estado'],
                    'proyecto_id' => $proyecto->id,
                    'bloque_id' => $bloque->id,
                    'fecha_registro' => $piezaData['fecha'] ? $piezaData['fecha'] . ' 08:00:00' : null,
                    'registrado_por' => $usuario?->id,
                ]);
            }
        }
    }
}
