<script setup>
import { computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    piezasPorProyecto: Array
});

const totalGeneral = computed(() => {
    return props.piezasPorProyecto.reduce((sum, item) => sum + item.total_pendientes, 0);
});

const pesoTotalGeneral = computed(() => {
    return props.piezasPorProyecto.reduce((sum, item) => sum + parseFloat(item.peso_total), 0).toFixed(2);
});

const maxPiezas = computed(() => {
    return Math.max(...props.piezasPorProyecto.map(item => item.total_pendientes), 1);
});

const getBarWidth = (cantidad) => {
    return (cantidad / maxPiezas.value) * 100;
};
</script>

<template>
    <AppLayout title="Reporte de Piezas Pendientes">
        <div class="max-w-7xl mx-auto">
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Reporte de Piezas Pendientes</h1>
                <p class="text-gray-600 mt-1">Visualización de piezas pendientes por proyecto</p>
            </div>

            <!-- Estadísticas Generales -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white border border-gray-200 rounded-md p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Proyectos</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ piezasPorProyecto.length }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-md p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Piezas Pendientes</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ totalGeneral }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-md p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Peso Total</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ pesoTotalGeneral }} kg</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráfico de Barras -->
            <div class="bg-white border border-gray-200 rounded-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Piezas Pendientes por Proyecto</h3>
                <div class="space-y-4">
                    <div v-for="item in piezasPorProyecto" :key="item.codigo" class="flex items-center">
                        <div class="w-32 flex-shrink-0">
                            <p class="text-sm font-medium text-gray-700">{{ item.codigo }}</p>
                        </div>
                        <div class="flex-1 mx-4">
                            <div class="bg-gray-100 rounded-full h-6 relative">
                                <div 
                                    class="bg-blue-500 h-6 rounded-full transition-all duration-500 flex items-center justify-end pr-2"
                                    :style="{ width: getBarWidth(item.total_pendientes) + '%' }"
                                >
                                    <span class="text-xs font-medium text-white">{{ item.total_pendientes }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-24 flex-shrink-0 text-right">
                            <p class="text-sm text-gray-600">{{ item.peso_total }} kg</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detalle por Proyecto -->
            <div class="space-y-6">
                <div v-for="item in piezasPorProyecto" :key="item.codigo" class="bg-white border border-gray-200 rounded-md overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ item.codigo }} - {{ item.nombre }}</h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ item.total_pendientes }} pieza{{ item.total_pendientes !== 1 ? 's' : '' }} pendiente{{ item.total_pendientes !== 1 ? 's' : '' }} · 
                                    Peso total: {{ item.peso_total }} kg
                                </p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ item.total_pendientes }} pendiente{{ item.total_pendientes !== 1 ? 's' : '' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                            Pieza
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                            Bloque
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                            Peso Teórico (kg)
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                            Estado
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="pieza in item.piezas" :key="pieza.id" class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="font-medium text-gray-900">{{ pieza.pieza }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                            {{ pieza.bloque?.nombre_bloque }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                            {{ pieza.peso_teorico }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-md bg-gray-100 text-gray-800 border border-gray-200">
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
            <div v-if="piezasPorProyecto.length === 0" class="bg-white border border-gray-200 rounded-md p-12 text-center">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">¡Excelente trabajo!</h3>
                <p class="mt-2 text-gray-600">No hay piezas pendientes por fabricar en este momento.</p>
            </div>
        </div>
    </AppLayout>
</template>
