<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ProyectoRepositoryInterface
{
    /**
     * Get all proyectos.
     */
    public function all(): Collection;

    /**
     * Find proyecto by ID.
     */
    public function find(int $id): ?Model;

    /**
     * Find proyecto by codigo.
     */
    public function findByCodigo(string $codigo): ?Model;

    /**
     * Create a new proyecto.
     */
    public function create(array $data): Model;

    /**
     * Update a proyecto.
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete a proyecto.
     */
    public function delete(int $id): bool;

    /**
     * Get proyecto with bloques.
     */
    public function getWithBloques(int $id): ?Model;

    /**
     * Get proyecto with estadisticas de piezas.
     */
    public function getWithEstadisticas(?int $id = null);
}
