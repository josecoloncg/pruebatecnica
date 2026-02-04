@extends('layouts.app')

@section('title', 'Detalle de la Pieza')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">🔧 Pieza: {{ $pieza->pieza }}</h1>
        <div class="space-x-2">
            <a href="{{ route('piezas.edit', $pieza->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition">
                ✏️ Editar
            </a>
            <a href="{{ route('piezas.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition">
                ← Volver
            </a>
        </div>
    </div>

    <!-- Información de la Pieza -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Información de la Pieza</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600">Nombre de la Pieza</p>
                <p class="font-semibold text-gray-800">{{ $pieza->pieza }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Estado</p>
                <p class="font-semibold">
                    @if($pieza->estado === 'Fabricado')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            ✓ Fabricado
                        </span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            ⏳ Pendiente
                        </span>
                    @endif
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Proyecto</p>
                <p class="font-semibold text-gray-800">{{ $pieza->proyecto->codigo }} - {{ $pieza->proyecto->nombre }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Bloque</p>
                <p class="font-semibold text-gray-800">{{ $pieza->bloque->nombre_bloque }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Peso Teórico</p>
                <p class="font-semibold text-gray-800">{{ $pieza->peso_teorico }} kg</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Peso Real</p>
                <p class="font-semibold text-gray-800">{{ $pieza->peso_real ?? 'No registrado' }} kg</p>
            </div>
            @if($pieza->peso_real)
            <div>
                <p class="text-sm text-gray-600">Diferencia de Peso</p>
                <p class="font-semibold {{ $pieza->diferencia_peso > 0 ? 'text-red-600' : ($pieza->diferencia_peso < 0 ? 'text-green-600' : 'text-gray-800') }}">
                    {{ $pieza->diferencia_peso }} kg
                    @if($pieza->diferencia_peso > 0)
                        ↑ (Exceso)
                    @elseif($pieza->diferencia_peso < 0)
                        ↓ (Déficit)
                    @else
                        ✓ (Exacto)
                    @endif
                </p>
            </div>
            @endif
            <div>
                <p class="text-sm text-gray-600">Fecha de Registro</p>
                <p class="font-semibold text-gray-800">{{ $pieza->fecha_registro ? $pieza->fecha_registro->format('d/m/Y H:i') : 'No registrada' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Registrado por</p>
                <p class="font-semibold text-gray-800">{{ $pieza->usuario->name ?? 'No asignado' }}</p>
            </div>
        </div>
    </div>

    <!-- Historial/Detalles Adicionales -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Detalles Adicionales</h2>
        <div class="space-y-3">
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                <span class="text-gray-700">ID de la Pieza:</span>
                <span class="font-mono text-sm bg-gray-200 px-2 py-1 rounded">{{ $pieza->id }}</span>
            </div>
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                <span class="text-gray-700">Creado el:</span>
                <span class="font-medium">{{ $pieza->created_at->format('d/m/Y H:i:s') }}</span>
            </div>
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                <span class="text-gray-700">Última actualización:</span>
                <span class="font-medium">{{ $pieza->updated_at->format('d/m/Y H:i:s') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
