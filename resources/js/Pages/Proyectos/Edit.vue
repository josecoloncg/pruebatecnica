<template>
    <AppLayout title="Editar Proyecto">
        <div class="max-w-3xl mx-auto">
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Editar Proyecto</h1>
                <p class="text-gray-600 mt-1">Modifica los datos del proyecto</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <form @submit.prevent="submit">
                    <div class="space-y-4">
                        <div>
                            <label for="codigo" class="block text-sm font-medium text-gray-700 mb-1">Código *</label>
                            <input 
                                id="codigo" 
                                v-model="form.codigo" 
                                type="text" 
                                maxlength="10"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                :class="{ 'border-red-500': form.errors.codigo }"
                                required
                            />
                            <p v-if="form.errors.codigo" class="mt-1 text-sm text-red-600">{{ form.errors.codigo }}</p>
                        </div>

                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                            <input 
                                id="nombre" 
                                v-model="form.nombre" 
                                type="text" 
                                maxlength="100"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                :class="{ 'border-red-500': form.errors.nombre }"
                                required
                            />
                            <p v-if="form.errors.nombre" class="mt-1 text-sm text-red-600">{{ form.errors.nombre }}</p>
                        </div>

                        <div>
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                            <textarea 
                                id="descripcion" 
                                v-model="form.descripcion" 
                                rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                :class="{ 'border-red-500': form.errors.descripcion }"
                            ></textarea>
                            <p v-if="form.errors.descripcion" class="mt-1 text-sm text-red-600">{{ form.errors.descripcion }}</p>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end space-x-3">
                        <Link :href="route('proyectos.index')" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
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
import { useForm, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    proyecto: Object
});

const form = useForm({
    codigo: props.proyecto.codigo,
    nombre: props.proyecto.nombre,
    descripcion: props.proyecto.descripcion
});

const submit = () => {
    form.put(route('proyectos.update', props.proyecto.id));
};
</script>
