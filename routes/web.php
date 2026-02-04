<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BloqueController;
use App\Http\Controllers\PiezaController;
use App\Http\Controllers\ProyectoController;
use Illuminate\Support\Facades\Route;

// Ruta principal - redirige al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    
    // Proyectos CRUD
    Route::resource('proyectos', ProyectoController::class);
    
    // Bloques CRUD
    Route::resource('bloques', BloqueController::class);
    
    // Piezas CRUD
    Route::resource('piezas', PiezaController::class);
    
    // Formulario de registro de peso
    Route::get('/piezas-formulario', [PiezaController::class, 'formulario'])->name('piezas.formulario');
    
    // Reporte de piezas pendientes
    Route::get('/piezas-reporte', [PiezaController::class, 'reporte'])->name('piezas.reporte');
    
    // Rutas API (mantener para Ajax)
    Route::prefix('api')->group(function () {
        // Proyectos
        Route::get('/proyectos', [ProyectoController::class, 'index']);
        Route::get('/proyectos/{id}/bloques', [ProyectoController::class, 'bloques']);
        
        // Bloques
        Route::get('/bloques', [BloqueController::class, 'index']);
        
        // Piezas
        Route::get('/piezas', [PiezaController::class, 'index']);
        Route::post('/piezas', [PiezaController::class, 'store']);
        Route::post('/piezas/{id}/registrar-peso', [PiezaController::class, 'registrarPeso']);
        Route::get('/reportes/piezas-pendientes-por-proyecto', [PiezaController::class, 'pendientesPorProyecto']);
    });
});
