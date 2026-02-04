<?php

use App\Http\Controllers\BloqueController;
use App\Http\Controllers\PiezaController;
use App\Http\Controllers\ProyectoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    
    // Ruta principal del formulario de registro de piezas
    Route::get('/formulario-piezas', function () {
        return Inertia::render('FormularioPiezas');
    })->name('formulario.piezas');
    
    // Ruta del reporte de piezas pendientes
    Route::get('/reporte-piezas', function () {
        return Inertia::render('ReportePiezas');
    })->name('reporte.piezas');
    
    // Rutas para la API interna (Inertia)
    Route::prefix('api')->group(function () {
        // Proyectos
        Route::get('/proyectos', [ProyectoController::class, 'index'])->name('api.proyectos.index');
        Route::get('/proyectos/{id}/bloques', [ProyectoController::class, 'bloques'])->name('api.proyectos.bloques');
        
        // Bloques
        Route::get('/bloques', [BloqueController::class, 'index'])->name('api.bloques.index');
        
        // Piezas
        Route::get('/piezas', [PiezaController::class, 'index'])->name('api.piezas.index');
        Route::post('/piezas', [PiezaController::class, 'store'])->name('api.piezas.store');
        Route::post('/piezas/{id}/registrar-peso', [PiezaController::class, 'registrarPeso'])->name('api.piezas.registrar-peso');
        
        // Reportes
        Route::get('/reportes/piezas-pendientes', [PiezaController::class, 'pendientesPorProyecto'])->name('api.reportes.pendientes');
    });
});
