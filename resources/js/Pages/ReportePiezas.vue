<script setup>
import { ref, onMounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';

const reporteData = ref([]);
const loading = ref(false);
const errorMessage = ref('');

const cargarReporte = async () => {
    try {
        loading.value = true;
        const response = await axios.get('/api/reportes/piezas-pendientes');
        reporteData.value = response.data.data;
    } catch (error) {
        console.error('Error cargando reporte:', error);
        errorMessage.value = 'Error al cargar el reporte';
    } finally {
        loading.value = false;
    }
};

const getTotalPendientes = () => {
    return reporteData.value.reduce((sum, item) => sum + item.total_pendientes, 0);
};

onMounted(() => {
    cargarReporte();
});
</script>

<template>
    <AppLayout title="Reporte de Piezas Pendientes">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Reporte de Piezas Pendientes por Proyecto
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Error Message -->
                <div v-if="errorMessage" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ errorMessage }}
                </div>

                <!-- Loading State -->
                <div v-if="loading" class="text-center py-12">
                    <svg class="animate-spin h-12 w-12 mx-auto text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="mt-4 text-gray-600">Cargando reporte...</p>
                </div>

                <!-- Reporte Content -->
                <div v-else>
                    <!-- Resumen General -->
                    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">
                                    Total Piezas Pendientes
                                </h3>
                                <p class="text-gray-600 mt-1">Agrupadas por proyecto</p>
                            </div>
                            <div class="text-5xl font-bold text-indigo-600">
                                {{ getTotalPendientes() }}
                            </div>
                        </div>
                    </div>

                    <!-- Reporte por Proyecto -->
                    <div class="space-y-6">
                        <div v-for="item in reporteData" :key="item.proyecto.id" class="bg-white rounded-lg shadow-lg overflow-hidden">
                            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-xl font-bold text-white">
                                            {{ item.proyecto.codigo }} - {{ item.proyecto.nombre }}
                                        </h3>
                                    </div>
                                    <div class="bg-white bg-opacity-20 rounded-full px-4 py-2">
                                        <span class="text-white font-bold text-lg">
                                            {{ item.total_pendientes }} pendientes
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Pieza
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Bloque
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Peso Teórico (kg)
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Estado
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr v-for="pieza in item.piezas" :key="pieza.id" class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="font-medium text-gray-900">{{ pieza.pieza }}</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                                    {{ pieza.bloque?.nombre_bloque }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                                    {{ pieza.peso_teorico }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Pendiente
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div v-if="reporteData.length === 0" class="bg-white rounded-lg shadow-lg p-12 text-center">
                        <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-4 text-xl font-medium text-gray-900">
                            ¡No hay piezas pendientes!
                        </h3>
                        <p class="mt-2 text-gray-500">
                            Todas las piezas han sido fabricadas.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
