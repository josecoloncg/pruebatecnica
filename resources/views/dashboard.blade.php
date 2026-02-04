@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-gray-900">Bienvenido, {{ Auth::user()->name }}</h1>
        <p class="text-gray-500 mt-1 text-sm">Sistema de Registro y Control de Piezas</p>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Proyectos Card -->
        <a href="{{ route('proyectos.index') }}" class="block group">
            <div class="bg-white border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-lg transition-all duration-200 p-6 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center group-hover:bg-blue-500 transition-colors duration-200">
                            <svg class="w-5 h-5 text-blue-500 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 group-hover:text-blue-500 transition">Proyectos</h3>
                            <p class="text-gray-500 text-xs mt-0.5">Gestionar proyectos</p>
                        </div>
                    </div>
                    <div class="text-gray-300 group-hover:text-blue-500 transition transform group-hover:translate-x-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </a>

        <!-- Bloques Card -->
        <a href="{{ route('bloques.index') }}" class="block group">
            <div class="bg-white border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-lg transition-all duration-200 p-6 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-50 rounded-lg flex items-center justify-center group-hover:bg-blue-500 transition-colors duration-200">
                            <svg class="w-5 h-5 text-gray-500 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 group-hover:text-blue-500 transition">Bloques</h3>
                            <p class="text-gray-500 text-xs mt-0.5">Gestionar bloques</p>
                        </div>
                    </div>
                    <div class="text-gray-300 group-hover:text-blue-500 transition transform group-hover:translate-x-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </a>

        <!-- Piezas Card -->
        <a href="{{ route('piezas.index') }}" class="block group">
            <div class="bg-white border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-lg transition-all duration-200 p-6 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-50 rounded-lg flex items-center justify-center group-hover:bg-blue-500 transition-colors duration-200">
                            <svg class="w-5 h-5 text-gray-500 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 group-hover:text-blue-500 transition">Piezas</h3>
                            <p class="text-gray-500 text-xs mt-0.5">Gestionar piezas</p>
                        </div>
                    </div>
                    <div class="text-gray-300 group-hover:text-blue-500 transition transform group-hover:translate-x-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </a>

        <!-- Registrar Peso Card -->
        <a href="{{ route('piezas.formulario') }}" class="block group">
            <div class="bg-white border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-lg transition-all duration-200 p-6 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center group-hover:bg-blue-500 transition-colors duration-200">
                            <svg class="w-5 h-5 text-blue-500 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 group-hover:text-blue-500 transition">Registrar Peso</h3>
                            <p class="text-gray-500 text-xs mt-0.5">Formulario de piezas</p>
                        </div>
                    </div>
                    <div class="text-gray-300 group-hover:text-blue-500 transition transform group-hover:translate-x-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </a>

        <!-- Reporte Card -->
        <a href="{{ route('piezas.reporte') }}" class="block group">
            <div class="bg-white border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-lg transition-all duration-200 p-6 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-50 rounded-lg flex items-center justify-center group-hover:bg-blue-500 transition-colors duration-200">
                            <svg class="w-5 h-5 text-gray-500 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 group-hover:text-blue-500 transition">Reporte</h3>
                            <p class="text-gray-500 text-xs mt-0.5">Piezas pendientes</p>
                        </div>
                    </div>
                    <div class="text-gray-300 group-hover:text-blue-500 transition transform group-hover:translate-x-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection
