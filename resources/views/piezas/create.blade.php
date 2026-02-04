@extends('layouts.app')

@section('title', 'Crear Pieza')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">➕ Crear Pieza</h1>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg p-6">
        <form action="{{ route('piezas.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="proyecto_id" class="block text-gray-700 text-sm font-medium mb-2">Proyecto *</label>
                <select name="proyecto_id" 
                        id="proyecto_id" 
                        required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 @error('proyecto_id') border-red-500 @enderror">
                    <option value="">Seleccione un proyecto</option>
                    @foreach($proyectos as $proyecto)
                        <option value="{{ $proyecto->id }}" {{ old('proyecto_id') == $proyecto->id ? 'selected' : '' }}>
                            {{ $proyecto->codigo }} - {{ $proyecto->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('proyecto_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="bloque_id" class="block text-gray-700 text-sm font-medium mb-2">Bloque *</label>
                <select name="bloque_id" 
                        id="bloque_id" 
                        required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 @error('bloque_id') border-red-500 @enderror">
                    <option value="">Seleccione un bloque</option>
                    @foreach($bloques as $bloque)
                        <option value="{{ $bloque->id }}" data-proyecto="{{ $bloque->proyecto_id }}" {{ old('bloque_id') == $bloque->id ? 'selected' : '' }}>
                            {{ $bloque->nombre_bloque }}
                        </option>
                    @endforeach
                </select>
                @error('bloque_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="pieza" class="block text-gray-700 text-sm font-medium mb-2">Nombre de la Pieza *</label>
                <input type="text" 
                       name="pieza" 
                       id="pieza" 
                       value="{{ old('pieza') }}" 
                       required
                       maxlength="50"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 @error('pieza') border-red-500 @enderror">
                @error('pieza')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="peso_teorico" class="block text-gray-700 text-sm font-medium mb-2">Peso Teórico (kg) *</label>
                <input type="number" 
                       name="peso_teorico" 
                       id="peso_teorico" 
                       value="{{ old('peso_teorico') }}" 
                       required
                       step="0.01"
                       min="0"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 @error('peso_teorico') border-red-500 @enderror">
                @error('peso_teorico')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="peso_real" class="block text-gray-700 text-sm font-medium mb-2">Peso Real (kg)</label>
                <input type="number" 
                       name="peso_real" 
                       id="peso_real" 
                       value="{{ old('peso_real') }}" 
                       step="0.01"
                       min="0"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 @error('peso_real') border-red-500 @enderror">
                @error('peso_real')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Dejar en blanco si aún no se ha fabricado</p>
            </div>

            <div class="mb-6">
                <label for="estado" class="block text-gray-700 text-sm font-medium mb-2">Estado *</label>
                <select name="estado" 
                        id="estado" 
                        required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 @error('estado') border-red-500 @enderror">
                    <option value="Pendiente" {{ old('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="Fabricado" {{ old('estado') == 'Fabricado' ? 'selected' : '' }}>Fabricado</option>
                </select>
                @error('estado')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('piezas.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-medium transition">
                    💾 Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('proyecto_id').addEventListener('change', function() {
    const proyectoId = this.value;
    const bloqueSelect = document.getElementById('bloque_id');
    const options = bloqueSelect.querySelectorAll('option[data-proyecto]');
    
    options.forEach(option => {
        if (proyectoId === '' || option.dataset.proyecto === proyectoId) {
            option.style.display = '';
        } else {
            option.style.display = 'none';
        }
    });
    
    bloqueSelect.value = '';
});
</script>
@endsection
