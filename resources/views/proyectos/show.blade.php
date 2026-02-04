@extends('layouts.app')

@section('title', 'Detalle del Proyecto')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">📁 {{ $proyecto->nombre }}</h1>
        <div class="space-x-2">
            <a href="{{ route('proyectos.edit', $proyecto->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition">
                ✏️ Editar
            </a>
            <a href="{{ route('proyectos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition">
                ← Volver
            </a>
        </div>
    </div>

    <!-- Información del Proyecto -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Información del Proyecto</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600">Código</p>
                <p class="font-semibold text-gray-800">{{ $proyecto->codigo }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Nombre</p>
                <p class="font-semibold text-gray-800">{{ $proyecto->nombre }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-600">Descripción</p>
                <p class="font-semibold text-gray-800">{{ $proyecto->descripcion ?? 'Sin descripción' }}</p>
            </div>
        </div>
    </div>

    <!-- Bloques del Proyecto -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">🧱 Bloques ({{ $proyecto->bloques->count() }})</h2>
        @if($proyecto->bloques->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre Bloque</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Piezas</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($proyecto->bloques as $bloque)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $bloque->nombre_bloque }}</td>
                            <td class="px-6 py-4">{{ $bloque->descripcion }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $bloque->piezas->count() }} piezas
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No hay bloques registrados en este proyecto</p>
        @endif
    </div>

    <!-- Piezas del Proyecto -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">🔧 Piezas ({{ $proyecto->piezas->count() }})</h2>
        @if($proyecto->piezas->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pieza</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bloque</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peso Teórico</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peso Real</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($proyecto->piezas as $pieza)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $pieza->pieza }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $pieza->bloque->nombre_bloque }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $pieza->peso_teorico }} kg</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $pieza->peso_real ?? '-' }} kg</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($pieza->estado === 'Fabricado')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        ✓ Fabricado
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        ⏳ Pendiente
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No hay piezas registradas en este proyecto</p>
        @endif
    </div>
</div>
@endsection
