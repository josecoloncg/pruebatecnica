<template>
    <AppLayout title="Piezas">
        <div class="max-w-7xl mx-auto">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">Piezas</h1>
                    <p class="text-gray-600 mt-1">Administrar todas las piezas del sistema</p>
                </div>
                <Link :href="route('piezas.create')" class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md font-medium transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Crear Pieza
                </Link>
            </div>

            <div class="bg-white border border-gray-200 rounded-md overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Pieza</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Proyecto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Bloque</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Peso Teórico</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Peso Real</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="pieza in piezas.data" :key="pieza.id" class="hover:bg-blue-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ pieza.pieza }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ pieza.proyecto?.nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ pieza.bloque?.nombre_bloque }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ pieza.peso_teorico }} kg</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ pieza.peso_real ? pieza.peso_real + ' kg' : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span :class="[
                                    'inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium',
                                    pieza.estado === 'Fabricado' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-yellow-50 text-yellow-700 border border-yellow-200'
                                ]">
                                    {{ pieza.estado }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <Link :href="route('piezas.edit', pieza.id)" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </Link>
                                <button @click="eliminar(pieza.id)" class="inline-flex items-center text-red-600 hover:text-red-900">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div v-if="piezas.links" class="mt-6">
                <div class="flex justify-center space-x-2">
                    <component 
                        :is="link.url ? Link : 'span'"
                        v-for="(link, index) in piezas.links" 
                        :key="index" 
                        :href="link.url" 
                        :class="[
                            'px-3 py-1 rounded',
                            link.active ? 'bg-blue-500 text-white' : link.url ? 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50' : 'bg-gray-100 border border-gray-200 text-gray-400 cursor-not-allowed'
                        ]"
                        v-html="link.label">
                    </component>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    piezas: Object
});

const eliminar = (id) => {
    if (confirm('¿Estás seguro de eliminar esta pieza?')) {
        router.delete(route('piezas.destroy', id));
    }
};
</script>
