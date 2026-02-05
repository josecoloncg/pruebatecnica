<?php

use App\Http\Controllers\BloqueController;
use App\Http\Controllers\PiezaController;
use App\Http\Controllers\ProyectoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Ruta principal - redirige según estado de autenticación
Route::get('/', function () {
    return Auth::check() 
        ? redirect()->route('proyectos.index') 
        : redirect()->route('login');
});

// Rutas protegidas por autenticación
Route::middleware(['auth:sanctum', config('jetstream.auth_session')])->group(function () {
    // Dashboard redirige a proyectos
    Route::get('/dashboard', function () {
        return redirect()->route('proyectos.index');
    })->name('dashboard');
    
    // Proyectos CRUD
    Route::resource('proyectos', ProyectoController::class);
    
    // Bloques CRUD
    Route::resource('bloques', BloqueController::class);
    
    // Piezas CRUD
    Route::resource('piezas', PiezaController::class);
    
    // Formulario de registro de peso
    Route::get('/piezas-formulario', [PiezaController::class, 'formulario'])->name('piezas.formulario');
    Route::post('/piezas/{id}/registrar-peso', [PiezaController::class, 'registrarPeso'])->name('piezas.registrarPeso');
    
    // Rutas para AJAX (sin prefijo /api)
    Route::get('/proyectos/{id}/bloques', [ProyectoController::class, 'bloques'])->name('proyectos.bloques');
    
    // Reporte de piezas pendientes
    Route::get('/piezas-reporte', [PiezaController::class, 'reporte'])->name('piezas.reporte');
});
