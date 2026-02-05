<template>
    <AppLayout title="Editar Pieza">
        <div class="max-w-3xl mx-auto">
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Editar Pieza</h1>
                <p class="text-gray-600 mt-1">Modifica los datos de la pieza</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <form @submit.prevent="submit">
                    <div class="space-y-4">
                        <div>
                            <label for="proyecto_id" class="block text-sm font-medium text-gray-700 mb-1">Proyecto *</label>
                            <select 
                                id="proyecto_id" 
                                v-model="form.proyecto_id"
                                @change="cargarBloques"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                :class="{ 'border-red-500': form.errors.proyecto_id }"
                                required
                            >
                                <option value="">Seleccione un proyecto</option>
                                <option v-for="proyecto in proyectos" :key="proyecto.id" :value="proyecto.id">
                                    {{ proyecto.codigo }} - {{ proyecto.nombre }}
                                </option>
                            </select>
                            <p v-if="form.errors.proyecto_id" class="mt-1 text-sm text-red-600">{{ form.errors.proyecto_id }}</p>
                        </div>

                        <div>
                            <label for="bloque_id" class="block text-sm font-medium text-gray-700 mb-1">Bloque *</label>
                            <select 
                                id="bloque_id" 
                                v-model="form.bloque_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                :class="{ 'border-red-500': form.errors.bloque_id }"
                                :disabled="!form.proyecto_id"
                                required
                            >
                                <option value="">Seleccione un bloque</option>
                                <option v-for="bloque in bloquesDisponibles" :key="bloque.id" :value="bloque.id">
                                    {{ bloque.nombre_bloque }}
                                </option>
                            </select>
                            <p v-if="form.errors.bloque_id" class="mt-1 text-sm text-red-600">{{ form.errors.bloque_id }}</p>
                        </div>

                        <div>
                            <label for="pieza" class="block text-sm font-medium text-gray-700 mb-1">Código Pieza *</label>
                            <input 
                                id="pieza" 
                                v-model="form.pieza" 
                                type="text" 
                                maxlength="10"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                :class="{ 'border-red-500': form.errors.pieza }"
                                required
                            />
                            <p v-if="form.errors.pieza" class="mt-1 text-sm text-red-600">{{ form.errors.pieza }}</p>
                        </div>

                        <div>
                            <label for="peso_teorico" class="block text-sm font-medium text-gray-700 mb-1">Peso Teórico (kg) *</label>
                            <input 
                                id="peso_teorico" 
                                v-model="form.peso_teorico" 
                                type="number" 
                                step="0.01"
                                min="0"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                :class="{ 'border-red-500': form.errors.peso_teorico }"
                                required
                            />
                            <p v-if="form.errors.peso_teorico" class="mt-1 text-sm text-red-600">{{ form.errors.peso_teorico }}</p>
                        </div>

                        <div>
                            <label for="peso_real" class="block text-sm font-medium text-gray-700 mb-1">Peso Real (kg)</label>
                            <input 
                                id="peso_real" 
                                v-model="form.peso_real" 
                                type="number" 
                                step="0.01"
                                min="0"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                :class="{ 'border-red-500': form.errors.peso_real }"
                            />
                            <p v-if="form.errors.peso_real" class="mt-1 text-sm text-red-600">{{ form.errors.peso_real }}</p>
                        </div>

                        <div>
                            <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado *</label>
                            <select 
                                id="estado" 
                                v-model="form.estado"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                :class="{ 'border-red-500': form.errors.estado }"
                                required
                            >
                                <option value="Pendiente">Pendiente</option>
                                <option value="Fabricado">Fabricado</option>
                            </select>
                            <p v-if="form.errors.estado" class="mt-1 text-sm text-red-600">{{ form.errors.estado }}</p>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end space-x-3">
                        <Link :href="route('piezas.index')" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                            Cancelar
                        </Link>
                        <button 
                            type="submit" 
                            :disabled="form.processing"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition disabled:opacity-50"
                        >
                            {{ form.processing ? 'Guardando...' : 'Actualizar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';

const props = defineProps({
    pieza: Object,
    proyectos: Array,
    bloques: Array
});

const bloquesDisponibles = ref(props.bloques);

const form = useForm({
    pieza: props.pieza.pieza,
    peso_teorico: props.pieza.peso_teorico,
    peso_real: props.pieza.peso_real,
    proyecto_id: props.pieza.proyecto_id,
    bloque_id: props.pieza.bloque_id,
    estado: props.pieza.estado
});

const cargarBloques = async () => {
    if (form.proyecto_id) {
        try {
            const response = await axios.get(`/proyectos/${form.proyecto_id}/bloques`);
            bloquesDisponibles.value = response.data;
        } catch (error) {
            console.error('Error cargando bloques:', error);
        }
    }
};

onMounted(() => {
    if (form.proyecto_id) {
        cargarBloques();
    }
});

const submit = () => {
    form.put(route('piezas.update', props.pieza.id));
};
</script>
