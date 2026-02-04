@extends('layouts.app')

@section('title', 'Registrar Peso de Pieza')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Registrar Peso de Pieza</h1>
        <p class="text-gray-500 mt-1 text-sm">Complete el formulario para registrar el peso real de piezas pendientes</p>
    </div>

    <!-- Progress Indicator -->
    <div class="mb-6">
        <div class="flex items-center justify-between text-sm">
            <div class="flex-1 text-center">
                <div id="step1-indicator" class="w-8 h-8 mx-auto bg-blue-500 text-white rounded-full flex items-center justify-center font-medium">1</div>
                <p class="mt-1 text-xs text-gray-500">Proyecto</p>
            </div>
            <div class="flex-1 h-1 bg-gray-200 relative top-[-12px]"></div>
            <div class="flex-1 text-center">
                <div id="step2-indicator" class="w-8 h-8 mx-auto bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-medium">2</div>
                <p class="mt-1 text-xs text-gray-500">Bloque</p>
            </div>
            <div class="flex-1 h-1 bg-gray-200 relative top-[-12px]"></div>
            <div class="flex-1 text-center">
                <div id="step3-indicator" class="w-8 h-8 mx-auto bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-medium">3</div>
                <p class="mt-1 text-xs text-gray-500">Pieza</p>
            </div>
            <div class="flex-1 h-1 bg-gray-200 relative top-[-12px]"></div>
            <div class="flex-1 text-center">
                <div id="step4-indicator" class="w-8 h-8 mx-auto bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-medium">4</div>
                <p class="mt-1 text-xs text-gray-500">Peso</p>
            </div>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        <form id="formularioPeso">
            @csrf
            
            <!-- Proyecto -->
            <div class="mb-4 transform transition-all duration-300" id="proyecto-container">
                <label for="proyecto_id" class="flex items-center text-gray-700 text-sm font-medium mb-2">
                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                    Proyecto *
                </label>
                <div class="relative">
                    <select id="proyecto_id" 
                            name="proyecto_id"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <option value="">Seleccione un proyecto</option>
                    </select>
                    <div id="proyecto-loading" class="hidden absolute right-3 top-3">
                        <svg class="animate-spin h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Bloque -->
            <div class="mb-4 transform transition-all duration-300" id="bloque-container">
                <label for="bloque_id" class="flex items-center text-gray-700 text-sm font-medium mb-2">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Bloque *
                </label>
                <select id="bloque_id" 
                        name="bloque_id"
                        required
                        disabled
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 disabled:bg-gray-50 disabled:text-gray-500 transition-all">
                    <option value="">Seleccione un bloque</option>
                </select>
            </div>

            <!-- Pieza -->
            <div class="mb-4 transform transition-all duration-300" id="pieza-container">
                <label for="pieza_id" class="flex items-center text-gray-700 text-sm font-medium mb-2">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path>
                    </svg>
                    Pieza *
                </label>
                <select id="pieza_id" 
                        name="pieza_id"
                        required
                        disabled
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 disabled:bg-gray-50 disabled:text-gray-500 transition-all">
                    <option value="">Seleccione una pieza</option>
                </select>
            </div>

            <!-- Info Card (Hidden by default) -->
            <div id="peso-info-card" class="hidden mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-blue-900 mb-1">Información de la Pieza</h4>
                        <p class="text-sm text-blue-700">Peso teórico: <span id="info-peso-teorico" class="font-semibold">-</span> kg</p>
                    </div>
                </div>
            </div>

            <!-- Peso Teórico (solo lectura) -->
            <div class="mb-4">
                <label for="peso_teorico" class="block text-gray-700 text-sm font-medium mb-2">Peso Teórico (kg)</label>
                <input type="number" 
                       id="peso_teorico" 
                       readonly
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-md bg-gray-50 text-gray-600">
            </div>

            <!-- Peso Real -->
            <div class="mb-4">
                <label for="peso_real" class="block text-gray-700 text-sm font-medium mb-2">Peso Real (kg) *</label>
                <input type="number" 
                       id="peso_real" 
                       name="peso_real"
                       required
                       step="0.01"
                       min="0"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
            </div>

            <!-- Diferencia (calculada automáticamente) -->
            <div class="mb-6">
                <label for="diferencia" class="block text-gray-700 text-sm font-medium mb-2">Diferencia de Peso (kg)</label>
                <input type="number" 
                       id="diferencia" 
                       readonly
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-md bg-gray-50 text-gray-600">
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-all hover:shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancelar
                </a>
                <button type="submit" id="btnGuardar" class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-all hover:shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span id="btn-text">Registrar Peso</span>
                    <svg id="btn-loading" class="hidden animate-spin ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let proyectos = [];
let bloques = [];
let piezas = [];

// Cargar proyectos al iniciar
document.addEventListener('DOMContentLoaded', async function() {
    await cargarProyectos();
});

async function cargarProyectos() {
    try {
        const response = await fetch('/api/proyectos', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        const data = await response.json();
        
        // Manejar tanto respuesta directa como respuesta envuelta
        proyectos = Array.isArray(data) ? data : (data.data || []);
        
        const select = document.getElementById('proyecto_id');
        select.innerHTML = '<option value="">Seleccione un proyecto</option>';
        
        if (proyectos.length === 0) {
            console.warn('No se encontraron proyectos');
            return;
        }
        
        proyectos.forEach(proyecto => {
            const option = document.createElement('option');
            option.value = proyecto.id;
            option.textContent = `${proyecto.codigo} - ${proyecto.nombre}`;
            select.appendChild(option);
        });
    } catch (error) {
        console.error('Error al cargar proyectos:', error);
        alert('Error al cargar los proyectos. Por favor recarga la página.');
    }
}

// Cuando cambia el proyecto, cargar bloques
document.getElementById('proyecto_id').addEventListener('change', async function() {
    const proyectoId = this.value;
    const bloqueSelect = document.getElementById('bloque_id');
    const piezaSelect = document.getElementById('pieza_id');
    
    // Actualizar indicador de progreso
    updateProgressIndicator(proyectoId ? 2 : 1);
    
    // Resetear campos
    bloqueSelect.innerHTML = '<option value="">Seleccione un bloque</option>';
    piezaSelect.innerHTML = '<option value="">Seleccione una pieza</option>';
    document.getElementById('peso_teorico').value = '';
    document.getElementById('peso_real').value = '';
    document.getElementById('diferencia').value = '';
    document.getElementById('peso-info-card').classList.add('hidden');
    
    if (!proyectoId) {
        bloqueSelect.disabled = true;
        piezaSelect.disabled = true;
        return;
    }
    
    try {
        const response = await fetch(`/api/proyectos/${proyectoId}/bloques`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        const data = await response.json();
        bloques = Array.isArray(data) ? data : (data.data || []);
        
        if (bloques.length === 0) {
            bloqueSelect.innerHTML = '<option value="">No hay bloques disponibles</option>';
            bloqueSelect.disabled = true;
            return;
        }
        
        bloques.forEach(bloque => {
            const option = document.createElement('option');
            option.value = bloque.id;
            option.textContent = bloque.nombre_bloque;
            bloqueSelect.appendChild(option);
        });
        
        bloqueSelect.disabled = false;
        
        // Animación suave
        document.getElementById('bloque-container').classList.add('scale-105');
        setTimeout(() => {
            document.getElementById('bloque-container').classList.remove('scale-105');
        }, 200);
    } catch (error) {
        console.error('Error al cargar bloques:', error);
        alert('Error al cargar los bloques. Por favor intenta de nuevo.');
    }
});

// Cuando cambia el bloque, cargar piezas pendientes
document.getElementById('bloque_id').addEventListener('change', async function() {
    const bloqueId = this.value;
    const piezaSelect = document.getElementById('pieza_id');
    
    // Actualizar indicador de progreso
    updateProgressIndicator(bloqueId ? 3 : 2);
    
    piezaSelect.innerHTML = '<option value="">Seleccione una pieza</option>';
    document.getElementById('peso_teorico').value = '';
    document.getElementById('peso_real').value = '';
    document.getElementById('diferencia').value = '';
    document.getElementById('peso-info-card').classList.add('hidden');
    
    if (!bloqueId) {
        piezaSelect.disabled = true;
        return;
    }
    
    try {
        const response = await fetch(`/api/piezas?bloque_id=${bloqueId}&solo_pendientes=true`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        const data = await response.json();
        piezas = Array.isArray(data) ? data : (data.data || []);
        
        if (piezas.length === 0) {
            piezaSelect.innerHTML = '<option value="">No hay piezas pendientes</option>';
            piezaSelect.disabled = true;
            return;
        }
        
        piezas.forEach(pieza => {
            const option = document.createElement('option');
            option.value = pieza.id;
            option.textContent = pieza.pieza;
            option.dataset.pesoTeorico = pieza.peso_teorico;
            piezaSelect.appendChild(option);
        });
        
        piezaSelect.disabled = false;
        
        // Animación suave
        document.getElementById('pieza-container').classList.add('scale-105');
        setTimeout(() => {
            document.getElementById('pieza-container').classList.remove('scale-105');
        }, 200);
    } catch (error) {
        console.error('Error al cargar piezas:', error);
        alert('Error al cargar las piezas. Por favor intenta de nuevo.');
    }
});

// Cuando cambia la pieza, cargar peso teórico
document.getElementById('pieza_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const pesoTeorico = selectedOption.dataset.pesoTeorico || '';
    
    if (pesoTeorico) {
        document.getElementById('peso_teorico').value = pesoTeorico;
        document.getElementById('info-peso-teorico').textContent = pesoTeorico;
        document.getElementById('peso-info-card').classList.remove('hidden');
        updateProgressIndicator(4);
    }
    document.getElementById('peso_real').value = '';
    document.getElementById('diferencia').value = '';
});

// Calcular diferencia automáticamente
document.getElementById('peso_real').addEventListener('input', function() {
    const pesoTeorico = parseFloat(document.getElementById('peso_teorico').value) || 0;
    const pesoReal = parseFloat(this.value) || 0;
    const diferencia = pesoReal - pesoTeorico;
    
    const diferenciaInput = document.getElementById('diferencia');
    diferenciaInput.value = diferencia.toFixed(2);
    
    // Cambiar color según la diferencia
    if (diferencia > 0) {
        diferenciaInput.classList.remove('text-red-600', 'text-gray-600');
        diferenciaInput.classList.add('text-green-600', 'font-semibold');
    } else if (diferencia < 0) {
        diferenciaInput.classList.remove('text-green-600', 'text-gray-600');
        diferenciaInput.classList.add('text-red-600', 'font-semibold');
    } else {
        diferenciaInput.classList.remove('text-green-600', 'text-red-600');
        diferenciaInput.classList.add('text-gray-600');
    }
});

// Función para actualizar indicadores de progreso
function updateProgressIndicator(step) {
    const indicators = ['step1-indicator', 'step2-indicator', 'step3-indicator', 'step4-indicator'];
    
    indicators.forEach((id, index) => {
        const element = document.getElementById(id);
        if (index < step) {
            element.classList.remove('bg-gray-200', 'text-gray-500');
            element.classList.add('bg-blue-500', 'text-white');
        } else {
            element.classList.remove('bg-blue-500', 'text-white');
            element.classList.add('bg-gray-200', 'text-gray-500');
        }
    });
}

// Enviar formulario
document.getElementById('formularioPeso').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const piezaId = document.getElementById('pieza_id').value;
    const pesoReal = document.getElementById('peso_real').value;
    
    if (!piezaId || !pesoReal) {
        alert('Por favor complete todos los campos requeridos');
        return;
    }
    
    const btnGuardar = document.getElementById('btnGuardar');
    const btnText = document.getElementById('btn-text');
    const btnLoading = document.getElementById('btn-loading');
    
    btnGuardar.disabled = true;
    btnText.classList.add('hidden');
    btnLoading.classList.remove('hidden');
    
    try {
        const response = await fetch(`/api/piezas/${piezaId}/registrar-peso`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ peso_real: pesoReal })
        });
        
        if (response.ok) {
            // Mostrar mensaje de éxito
            const successDiv = document.createElement('div');
            successDiv.className = 'fixed top-4 right-4 bg-white border-l-4 border-green-500 text-gray-900 px-6 py-4 rounded-lg shadow-xl z-50 transform transition-all duration-300';
            successDiv.innerHTML = `
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">Peso registrado exitosamente</span>
                </div>
            `;
            document.body.appendChild(successDiv);
            
            setTimeout(() => {
                successDiv.classList.add('opacity-0', 'translate-x-full');
                setTimeout(() => successDiv.remove(), 300);
            }, 3000);
            
            this.reset();
            document.getElementById('bloque_id').disabled = true;
            document.getElementById('pieza_id').disabled = true;
            document.getElementById('peso-info-card').classList.add('hidden');
            updateProgressIndicator(1);
            await cargarProyectos();
        } else {
            const error = await response.json();
            alert('Error: ' + (error.message || 'No se pudo registrar el peso'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al registrar el peso');
    } finally {
        btnGuardar.disabled = false;
        btnText.classList.remove('hidden');
        btnLoading.classList.add('hidden');
    }
});
</script>
@endsection
