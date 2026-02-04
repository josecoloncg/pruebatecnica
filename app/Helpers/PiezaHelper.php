<?php

namespace App\Helpers;

class PiezaHelper
{
    /**
     * Calcula la diferencia entre peso real y teórico.
     */
    public static function calcularDiferenciaPeso(?float $pesoReal, float $pesoTeorico): ?float
    {
        if ($pesoReal === null) {
            return null;
        }

        return round($pesoReal - $pesoTeorico, 2);
    }

    /**
     * Verifica si una pieza está dentro del rango de tolerancia.
     */
    public static function estaDentroDeTolerancia(?float $diferencia, float $toleranciaKg = 0.5): ?bool
    {
        if ($diferencia === null) {
            return null;
        }

        return abs($diferencia) <= $toleranciaKg;
    }

    /**
     * Formatea el código de bloque combinado (IDProyecto-NombreBloque).
     */
    public static function formatearCodigoBloque(int $proyectoId, string $nombreBloque): string
    {
        return "{$proyectoId}-{$nombreBloque}";
    }

    /**
     * Genera estadísticas de piezas.
     */
    public static function generarEstadisticas(array $piezas): array
    {
        $total = count($piezas);
        $pendientes = collect($piezas)->where('estado', 'Pendiente')->count();
        $fabricadas = collect($piezas)->where('estado', 'Fabricado')->count();

        return [
            'total' => $total,
            'pendientes' => $pendientes,
            'fabricadas' => $fabricadas,
            'porcentaje_completado' => $total > 0 ? round(($fabricadas / $total) * 100, 2) : 0,
        ];
    }
}
