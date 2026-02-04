@extends('layouts.app')

@section('title', 'Detalle del Bloque')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">🧱 Bloque: {{ $bloque->nombre_bloque }}</h1>
        <div class="space-x-2">
            <a href="{{ route('bloques.edit', $bloque->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition">
                ✏️ Editar
            </a>
            <a href="{{ route('bloques.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition">
                ← Volver
            </a>
        </div>
    </div>

    <!-- Información del Bloque -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Información del Bloque</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600">Nombre del Bloque</p>
                <p class="font-semibold text-gray-800">{{ $bloque->nombre_bloque }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Proyecto</p>
                <p class="font-semibold text-gray-800">{{ $bloque->proyecto->codigo }} - {{ $bloque->proyecto->nombre }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-600">Descripción</p>
                <p class="font-semibold text-gray-800">{{ $bloque->descripcion ?? 'Sin descripción' }}</p>
            </div>
        </div>
    </div>

    <!-- Piezas del Bloque -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">🔧 Piezas ({{ $bloque->piezas->count() }})</h2>
        @if($bloque->piezas->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pieza</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peso Teórico</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peso Real</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diferencia</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registrado por</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($bloque->piezas as $pieza)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $pieza->pieza }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $pieza->peso_teorico }} kg</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $pieza->peso_real ?? '-' }} kg</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($pieza->peso_real)
                                    {{ $pieza->diferencia_peso }} kg
                                @else
                                    -
                                @endif
                            </td>
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
                            <td class="px-6 py-4 whitespace-nowrap">{{ $pieza->usuario->name ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No hay piezas registradas en este bloque</p>
        @endif
    </div>
</div>
@endsection
