@extends('layouts.app')

@section('title', 'Bloques')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Bloques</h1>
        <a href="{{ route('bloques.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium transition">
            Nuevo Bloque
        </a>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre Bloque</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proyecto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Piezas</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($bloques as $bloque)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $bloque->nombre_bloque }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium rounded bg-gray-100 text-gray-700">
                            {{ $bloque->proyecto->codigo }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $bloque->descripcion }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium rounded bg-gray-100 text-gray-700">
                            {{ $bloque->piezas_count }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                        <a href="{{ route('bloques.show', $bloque->id) }}" class="text-blue-500 hover:text-blue-700 mr-3">Ver</a>
                        <a href="{{ route('bloques.edit', $bloque->id) }}" class="text-gray-500 hover:text-gray-700 mr-3">Editar</a>
                        <form action="{{ route('bloques.destroy', $bloque->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este bloque?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-gray-600">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay bloques registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $bloques->links() }}
    </div>
</div>
@endsection
