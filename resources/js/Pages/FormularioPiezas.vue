<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';

// Estados reactivos
const proyectos = ref([]);
const bloques = ref([]);
const piezas = ref([]);
const loading = ref(false);
const successMessage = ref('');
const errorMessage = ref('');

// Formulario
const form = useForm({
    proyecto_id: '',
    bloque_id: '',
    pieza_id: '',
    peso_real: '',
});

// Datos de la pieza seleccionada
const piezaSeleccionada = ref(null);

// Computed properties
const pesoTeorico = computed(() => {
    return piezaSeleccionada.value?.peso_teorico || 0;
});

const diferenciaPeso = computed(() => {
    if (!form.peso_real || !pesoTeorico.value) {
        return null;
    }
    const diferencia = parseFloat(form.peso_real) - parseFloat(pesoTeorico.value);
    return diferencia.toFixed(2);
});

const fechaHoraActual = computed(() => {
    return new Date().toLocaleString('es-ES', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
    });
});

// Watchers
watch(() => form.proyecto_id, async (nuevoProyectoId) => {
    // Resetear bloques y piezas al cambiar proyecto
    form.bloque_id = '';
    form.pieza_id = '';
    bloques.value = [];
    piezas.value = [];
    piezaSeleccionada.value = null;
    form.peso_real = '';

    if (nuevoProyectoId) {
        await cargarBloques(nuevoProyectoId);
    }
});

watch(() => form.bloque_id, async (nuevoBloqueId) => {
    // Resetear piezas al cambiar bloque
    form.pieza_id = '';
    piezas.value = [];
    piezaSeleccionada.value = null;
    form.peso_real = '';

    if (nuevoBloqueId) {
        await cargarPiezasPendientes(nuevoBloqueId);
    }
});

watch(() => form.pieza_id, (nuevaPiezaId) => {
    if (nuevaPiezaId) {
        const pieza = piezas.value.find(p => p.id === parseInt(nuevaPiezaId));
        piezaSeleccionada.value = pieza;
    } else {
        piezaSeleccionada.value = null;
    }
    form.peso_real = '';
});

// Métodos para cargar datos
const cargarProyectos = async () => {
    try {
        loading.value = true;
        const response = await axios.get('/proyectos', {
            headers: { 'Accept': 'application/json' }
        });
        proyectos.value = response.data;
    } catch (error) {
        console.error('Error cargando proyectos:', error);
        mostrarError('Error al cargar proyectos');
    } finally {
        loading.value = false;
    }
};

const cargarBloques = async (proyectoId) => {
    try {
        loading.value = true;
        const response = await axios.get(`/proyectos/${proyectoId}/bloques`);
        bloques.value = response.data;
    } catch (error) {
        console.error('Error cargando bloques:', error);
        mostrarError('Error al cargar bloques');
    } finally {
        loading.value = false;
    }
};

const cargarPiezasPendientes = async (bloqueId) => {
    try {
        loading.value = true;
        const response = await axios.get(`/piezas?bloque_id=${bloqueId}&solo_pendientes=true`, {
            headers: { 'Accept': 'application/json' }
        });
        piezas.value = response.data;
    } catch (error) {
        console.error('Error cargando piezas:', error);
        mostrarError('Error al cargar piezas');
    } finally {
        loading.value = false;
    }
};

// Validaciones
const validarFormulario = () => {
    // Limpiar mensajes previos
    errorMessage.value = '';

    if (!form.proyecto_id) {
        mostrarError('Debe seleccionar un proyecto');
        return false;
    }

    if (!form.bloque_id) {
        mostrarError('Debe seleccionar un bloque');
        return false;
    }

    if (!form.pieza_id) {
        mostrarError('Debe seleccionar una pieza');
        return false;
    }

    if (!form.peso_real) {
        mostrarError('Debe ingresar el peso real');
        return false;
    }

    // Validar que sea numérico
    const pesoRealNum = parseFloat(form.peso_real);
    if (isNaN(pesoRealNum) || pesoRealNum <= 0) {
        mostrarError('El peso real debe ser un número mayor a 0');
        return false;
    }

    return true;
};

// Enviar formulario
const registrarPeso = async () => {
    if (!validarFormulario()) {
        return;
    }

    try {
        loading.value = true;
        
        const response = await axios.post(`/piezas/${form.pieza_id}/registrar-peso`, {
            peso_real: parseFloat(form.peso_real),
        });

        if (response.data.success) {
            mostrarExito('Peso registrado exitosamente');
            
            // Resetear formulario
            setTimeout(() => {
                resetearFormulario();
            }, 2000);
        }
    } catch (error) {
        console.error('Error registrando peso:', error);
        if (error.response?.data?.message) {
            mostrarError(error.response.data.message);
        } else {
            mostrarError('Error al registrar el peso');
        }
    } finally {
        loading.value = false;
    }
};

const resetearFormulario = () => {
    form.reset();
    piezaSeleccionada.value = null;
    bloques.value = [];
    piezas.value = [];
    successMessage.value = '';
    errorMessage.value = '';
};

const mostrarExito = (mensaje) => {
    successMessage.value = mensaje;
    errorMessage.value = '';
    setTimeout(() => {
        successMessage.value = '';
    }, 5000);
};

const mostrarError = (mensaje) => {
    errorMessage.value = mensaje;
    successMessage.value = '';
};

// Lifecycle
onMounted(() => {
    cargarProyectos();
});
</script>

<template>
    <AppLayout title="Formulario de Registro de Piezas">
        <div class="max-w-4xl mx-auto">
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Registro de Piezas</h1>
                <p class="text-gray-600 mt-1">Registrar peso real de las piezas fabricadas</p>
            </div>
                <!-- Mensajes -->
                <div v-if="successMessage" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ successMessage }}</span>
                </div>

                <div v-if="errorMessage" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ errorMessage }}</span>
                </div>

                <!-- Formulario Principal -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:p-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">
                            Registrar Peso de Pieza
                        </h3>

                        <form @submit.prevent="registrarPeso" class="space-y-6">
                            <!-- Fecha y Hora Actual -->
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm font-medium text-blue-900">
                                        Fecha y Hora: {{ fechaHoraActual }}
                                    </span>
                                </div>
                            </div>

                            <!-- Selección de Proyecto -->
                            <div>
                                <label for="proyecto" class="block text-sm font-medium text-gray-700 mb-2">
                                    Proyecto <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="proyecto"
                                    v-model="form.proyecto_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    :disabled="loading"
                                    required
                                >
                                    <option value="">Seleccione un proyecto</option>
                                    <option v-for="proyecto in proyectos" :key="proyecto.id" :value="proyecto.id">
                                        {{ proyecto.codigo }} - {{ proyecto.nombre }}
                                    </option>
                                </select>
                            </div>

                            <!-- Selección de Bloque -->
                            <div>
                                <label for="bloque" class="block text-sm font-medium text-gray-700 mb-2">
                                    Bloque <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="bloque"
                                    v-model="form.bloque_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    :disabled="!form.proyecto_id || loading || bloques.length === 0"
                                    required
                                >
                                    <option value="">{{ form.proyecto_id ? 'Seleccione un bloque' : 'Primero seleccione un proyecto' }}</option>
                                    <option v-for="bloque in bloques" :key="bloque.id" :value="bloque.id">
                                        {{ bloque.nombre_bloque }}
                                    </option>
                                </select>
                                <p v-if="form.proyecto_id && bloques.length === 0 && !loading" class="mt-2 text-sm text-gray-500">
                                    No hay bloques disponibles para este proyecto
                                </p>
                            </div>

                            <!-- Selección de Pieza -->
                            <div>
                                <label for="pieza" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pieza Pendiente <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="pieza"
                                    v-model="form.pieza_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    :disabled="!form.bloque_id || loading || piezas.length === 0"
                                    required
                                >
                                    <option value="">{{ form.bloque_id ? 'Seleccione una pieza' : 'Primero seleccione un bloque' }}</option>
                                    <option v-for="pieza in piezas" :key="pieza.id" :value="pieza.id">
                                        {{ pieza.pieza }} (Peso teórico: {{ pieza.peso_teorico }} kg)
                                    </option>
                                </select>
                                <p v-if="form.bloque_id && piezas.length === 0 && !loading" class="mt-2 text-sm text-green-600">
                                    ✓ No hay piezas pendientes en este bloque
                                </p>
                            </div>

                            <!-- Peso Teórico (No editable) -->
                            <div>
                                <label for="peso_teorico" class="block text-sm font-medium text-gray-700 mb-2">
                                    Peso Teórico (kg)
                                </label>
                                <input
                                    id="peso_teorico"
                                    type="text"
                                    :value="pesoTeorico"
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm sm:text-sm cursor-not-allowed"
                                    readonly
                                    disabled
                                />
                            </div>

                            <!-- Peso Real -->
                            <div>
                                <label for="peso_real" class="block text-sm font-medium text-gray-700 mb-2">
                                    Peso Real (kg) <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="peso_real"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    v-model="form.peso_real"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    :disabled="!form.pieza_id || loading"
                                    placeholder="Ingrese el peso real"
                                    required
                                />
                            </div>

                            <!-- Diferencia de Peso (No editable) -->
                            <div v-if="diferenciaPeso !== null">
                                <label for="diferencia" class="block text-sm font-medium text-gray-700 mb-2">
                                    Diferencia (Real - Teórico)
                                </label>
                                <div class="mt-1 flex items-center">
                                    <input
                                        id="diferencia"
                                        type="text"
                                        :value="diferenciaPeso + ' kg'"
                                        class="block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm sm:text-sm cursor-not-allowed"
                                        :class="{
                                            'text-green-700 font-semibold': parseFloat(diferenciaPeso) >= 0,
                                            'text-red-700 font-semibold': parseFloat(diferenciaPeso) < 0
                                        }"
                                        readonly
                                        disabled
                                    />
                                    <span v-if="parseFloat(diferenciaPeso) > 0" class="ml-2 text-green-600">
                                        ↑
                                    </span>
                                    <span v-else-if="parseFloat(diferenciaPeso) < 0" class="ml-2 text-red-600">
                                        ↓
                                    </span>
                                    <span v-else class="ml-2 text-blue-600">
                                        =
                                    </span>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="flex items-center justify-end space-x-4 pt-4">
                                <button
                                    type="button"
                                    @click="resetearFormulario"
                                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    :disabled="loading"
                                >
                                    Limpiar
                                </button>
                                <button
                                    type="submit"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed"
                                    :disabled="loading || !form.pieza_id || !form.peso_real"
                                >
                                    <span v-if="loading" class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Procesando...
                                    </span>
                                    <span v-else>
                                        Registrar Peso
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Información Adicional -->
                <div class="mt-6 bg-gray-50 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Instrucciones:</h4>
                    <ul class="text-sm text-gray-600 space-y-1 list-disc list-inside">
                        <li>Seleccione un proyecto para ver sus bloques asociados</li>
                        <li>Seleccione un bloque para ver solo las piezas pendientes</li>
                        <li>El peso teórico se carga automáticamente al seleccionar la pieza</li>
                        <li>Ingrese el peso real medido de la pieza</li>
                        <li>La diferencia se calcula automáticamente (Peso Real - Peso Teórico)</li>
                    </ul>
                </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* Estilos adicionales si es necesario */
select:disabled,
input:disabled {
    cursor: not-allowed;
    opacity: 0.6;
}
</style>
