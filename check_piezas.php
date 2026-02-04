<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Bloque;
use App\Models\Pieza;

echo "=== BLOQUES ===\n";
$bloques = Bloque::with('piezas')->get();
foreach ($bloques as $bloque) {
    echo "Bloque ID: {$bloque->id}, Nombre: {$bloque->bloque}, Piezas: " . $bloque->piezas->count() . "\n";
}

echo "\n=== PIEZAS ===\n";
$piezas = Pieza::all();
foreach ($piezas as $pieza) {
    echo "ID: {$pieza->id}, Pieza: {$pieza->pieza}, Estado: {$pieza->estado}, Bloque ID: {$pieza->bloque_id}\n";
}

echo "\n=== PIEZAS PENDIENTES POR BLOQUE ===\n";
foreach ($bloques as $bloque) {
    $pendientes = Pieza::where('bloque_id', $bloque->id)
                       ->where('estado', 'Pendiente')
                       ->count();
    echo "Bloque {$bloque->bloque} (ID: {$bloque->id}): {$pendientes} piezas pendientes\n";
}
