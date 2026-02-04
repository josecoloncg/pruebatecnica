<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Pieza;

// Cambiar las primeras 4 piezas a estado Pendiente
$piezas = Pieza::whereIn('id', [1, 2, 3, 4])->get();

foreach ($piezas as $pieza) {
    $pieza->estado = 'Pendiente';
    $pieza->peso_real = null;
    $pieza->registrado_por = null;
    $pieza->fecha_registro = null;
    $pieza->save();
    echo "Pieza {$pieza->pieza} (ID: {$pieza->id}) cambiada a Pendiente\n";
}

echo "\nPiezas pendientes actualizadas exitosamente.\n";
