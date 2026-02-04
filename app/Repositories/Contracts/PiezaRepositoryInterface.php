<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface PiezaRepositoryInterface
{
    /**
     * Get all piezas.
     */
    public function all(): Collection;

    /**
     * Find pieza by ID.
     */
    public function find(int $id): ?Model;

    /**
     * Get piezas by bloque ID.
     */
    public function getByBloque(int $bloqueId): Collection;

    /**
     * Get piezas pendientes by bloque ID.
     */
    public function getPendientesByBloque(int $bloqueId): Collection;

    /**
     * Get piezas by proyecto ID.
     */
    public function getByProyecto(int $proyectoId): Collection;

    /**
     * Create a new pieza.
     */
    public function create(array $data): Model;

    /**
     * Update a pieza.
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete a pieza.
     */
    public function delete(int $id): bool;

    /**
     * Mark pieza as fabricado.
     */
    public function marcarComoFabricado(int $id, float $pesoReal, int $usuarioId): bool;

    /**
     * Get piezas with pagination.
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    /**
     * Get piezas pendientes agrupadas por proyecto.
     */
    public function getPendientesAgrupadasPorProyecto(): Collection;
}
