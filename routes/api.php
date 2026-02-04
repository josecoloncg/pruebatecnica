<?php

use App\Http\Controllers\BloqueController;
use App\Http\Controllers\PiezaController;
use App\Http\Controllers\ProyectoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas protegidas con autenticación Sanctum
Route::middleware('auth:sanctum')->group(function () {
    
    // Rutas de Proyectos
    Route::apiResource('proyectos', ProyectoController::class);
    Route::get('proyectos/{id}/bloques', [ProyectoController::class, 'bloques']);
    
    // Rutas de Bloques
    Route::apiResource('bloques', BloqueController::class);
    
    // Rutas de Piezas
    Route::apiResource('piezas', PiezaController::class);
    Route::post('piezas/{id}/registrar-peso', [PiezaController::class, 'registrarPeso']);
    Route::get('reportes/piezas-pendientes-por-proyecto', [PiezaController::class, 'pendientesPorProyecto']);
    
});
