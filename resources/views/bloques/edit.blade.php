@extends('layouts.app')

@section('title', 'Editar Bloque')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">✏️ Editar Bloque</h1>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg p-6">
        <form action="{{ route('bloques.update', $bloque->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="proyecto_id" class="block text-gray-700 text-sm font-medium mb-2">Proyecto *</label>
                <select name="proyecto_id" 
                        id="proyecto_id" 
                        required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('proyecto_id') border-red-500 @enderror">
                    <option value="">Seleccione un proyecto</option>
                    @foreach($proyectos as $proyecto)
                        <option value="{{ $proyecto->id }}" {{ old('proyecto_id', $bloque->proyecto_id) == $proyecto->id ? 'selected' : '' }}>
                            {{ $proyecto->codigo }} - {{ $proyecto->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('proyecto_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="nombre_bloque" class="block text-gray-700 text-sm font-medium mb-2">Nombre del Bloque *</label>
                <input type="text" 
                       name="nombre_bloque" 
                       id="nombre_bloque" 
                       value="{{ old('nombre_bloque', $bloque->nombre_bloque) }}" 
                       required
                       maxlength="50"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('nombre_bloque') border-red-500 @enderror">
                @error('nombre_bloque')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="descripcion" class="block text-gray-700 text-sm font-medium mb-2">Descripción</label>
                <textarea name="descripcion" 
                          id="descripcion" 
                          rows="4"
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $bloque->descripcion) }}</textarea>
                @error('descripcion')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('bloques.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-medium transition">
                    💾 Actualizar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
