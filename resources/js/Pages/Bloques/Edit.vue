<template>
    <AppLayout title="Editar Bloque">
        <div class="max-w-3xl mx-auto">
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Editar Bloque</h1>
            </div>

            <div class="bg-white border border-gray-200 rounded-md p-6">
                <form @submit.prevent="submit">
                    <div class="mb-4">
                        <label for="proyecto_id" class="block text-gray-700 text-sm font-medium mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                            Proyecto *
                        </label>
                        <select v-model="form.proyecto_id" 
                                id="proyecto_id" 
                                required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                :class="{ 'border-red-500': form.errors.proyecto_id }">
                            <option value="">Seleccione un proyecto</option>
                            <option v-for="proyecto in proyectos" :key="proyecto.id" :value="proyecto.id">
                                {{ proyecto.codigo }} - {{ proyecto.nombre }}
                            </option>
                        </select>
                        <p v-if="form.errors.proyecto_id" class="text-red-500 text-xs mt-1">{{ form.errors.proyecto_id }}</p>
                    </div>

                    <div class="mb-4">
                        <label for="nombre_bloque" class="block text-gray-700 text-sm font-medium mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Nombre del Bloque *
                        </label>
                        <input v-model="form.nombre_bloque" 
                               type="text" 
                               id="nombre_bloque" 
                               required
                               maxlength="50"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               :class="{ 'border-red-500': form.errors.nombre_bloque }">
                        <p v-if="form.errors.nombre_bloque" class="text-red-500 text-xs mt-1">{{ form.errors.nombre_bloque }}</p>
                    </div>

                    <div class="mb-6">
                        <label for="descripcion" class="block text-gray-700 text-sm font-medium mb-2">Descripción</label>
                        <textarea v-model="form.descripcion" 
                                  id="descripcion" 
                                  rows="4"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  :class="{ 'border-red-500': form.errors.descripcion }"></textarea>
                        <p v-if="form.errors.descripcion" class="text-red-500 text-xs mt-1">{{ form.errors.descripcion }}</p>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <Link :href="route('bloques.index')" class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md font-medium transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancelar
                        </Link>
                        <button type="submit" :disabled="form.processing" class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md font-medium transition disabled:opacity-50">
                            <span v-if="!form.processing" class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Actualizar
                            </span>
                            <span v-else class="flex items-center">
                                <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Actualizando...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    bloque: Object,
    proyectos: Array
});

const form = useForm({
    proyecto_id: props.bloque.proyecto_id,
    nombre_bloque: props.bloque.nombre_bloque,
    descripcion: props.bloque.descripcion || ''
});

const submit = () => {
    form.put(route('bloques.update', props.bloque.id));
};
</script>
