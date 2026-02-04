@extends('layouts.app')

@section('title', 'Crear Proyecto')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Crear Proyecto</h1>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg p-6">
        <form action="{{ route('proyectos.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="codigo" class="block text-gray-700 text-sm font-medium mb-2">Código *</label>
                <input type="text" 
                       name="codigo" 
                       id="codigo" 
                       value="{{ old('codigo') }}" 
                       required
                       maxlength="10"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('codigo') border-red-500 @enderror">
                @error('codigo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 text-sm font-medium mb-2">Nombre *</label>
                <input type="text" 
                       name="nombre" 
                       id="nombre" 
                       value="{{ old('nombre') }}" 
                       required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nombre') border-red-500 @enderror">
                @error('nombre')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="descripcion" class="block text-gray-700 text-sm font-medium mb-2">Descripción</label>
                <textarea name="descripcion" 
                          id="descripcion" 
                          rows="4"
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('descripcion') border-red-500 @enderror">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('proyectos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
