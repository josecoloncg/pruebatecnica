<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BloqueRepositoryInterface
{
    /**
     * Get all bloques.
     */
    public function all(): Collection;

    /**
     * Find bloque by ID.
     */
    public function find(int $id): ?Model;

    /**
     * Get bloques by proyecto ID.
     */
    public function getByProyecto(int $proyectoId): Collection;

    /**
     * Create a new bloque.
     */
    public function create(array $data): Model;

    /**
     * Update a bloque.
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete a bloque.
     */
    public function delete(int $id): bool;

    /**
     * Get bloque with piezas pendientes.
     */
    public function getWithPiezasPendientes(int $id): ?Model;

    /**
     * Get all bloques with pagination.
     */
    public function getAllPaginated(int $perPage = 15);
}
