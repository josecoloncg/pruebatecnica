@extends('layouts.app')

@section('title', 'Reporte de Piezas Pendientes')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Reporte de Piezas Pendientes</h1>
        <p class="text-gray-500 mt-1 text-sm">Piezas pendientes agrupadas por proyecto</p>
    </div>

    @if($piezasPorProyecto && count($piezasPorProyecto) > 0)
        @foreach($piezasPorProyecto as $proyectoData)
        <div class="bg-white border border-gray-200 rounded-lg mb-6">
            <div class="bg-gray-900 text-white px-6 py-4 rounded-t-lg border-b border-gray-700">
                <h2 class="text-lg font-medium">
                    {{ $proyectoData['codigo'] }} - {{ $proyectoData['nombre'] }}
                </h2>
                <p class="text-sm mt-1 text-gray-300">{{ $proyectoData['total_pendientes'] }} piezas pendientes</p>
            </div>
            
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pieza</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bloque</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peso Teórico (kg)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($proyectoData['piezas'] as $pieza)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $pieza->pieza }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $pieza->bloque->nombre_bloque }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $pieza->peso_teorico }} kg</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded bg-blue-50 text-blue-600">
                                        Pendiente
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="2" class="px-6 py-3 text-right font-medium text-gray-700">Subtotal:</td>
                                <td class="px-6 py-3 font-semibold text-gray-900">{{ $proyectoData['peso_total'] }} kg</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Total General -->
        <div class="bg-gray-900 text-white border border-gray-800 rounded-lg p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-semibold">Total General</h3>
                    <p class="text-sm mt-1 text-gray-300">Resumen de todas las piezas pendientes</p>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-semibold">{{ array_sum(array_column($piezasPorProyecto, 'total_pendientes')) }}</p>
                    <p class="text-sm mt-1 text-gray-300">piezas pendientes</p>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white border border-gray-200 rounded-lg p-12 text-center">
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No hay piezas pendientes</h3>
            <p class="text-gray-500">Todas las piezas han sido fabricadas</p>
        </div>
    @endif
</div>
@endsection
