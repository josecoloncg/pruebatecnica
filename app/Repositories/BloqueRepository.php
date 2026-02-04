<?php

namespace App\Repositories;

use App\Models\Bloque;
use App\Repositories\Contracts\BloqueRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BloqueRepository implements BloqueRepositoryInterface
{
    protected Model $model;

    public function __construct(Bloque $bloque)
    {
        $this->model = $bloque;
    }

    /**
     * Get all bloques.
     */
    public function all(): Collection
    {
        return $this->model->with('proyecto')->get();
    }

    /**
     * Find bloque by ID.
     */
    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Get bloques by proyecto ID.
     */
    public function getByProyecto(int $proyectoId): Collection
    {
        return $this->model
            ->where('proyecto_id', $proyectoId)
            ->orderBy('nombre_bloque')
            ->get();
    }

    /**
     * Create a new bloque.
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update a bloque.
     */
    public function update(int $id, array $data): bool
    {
        $bloque = $this->find($id);
        
        if (!$bloque) {
            return false;
        }

        return $bloque->update($data);
    }

    /**
     * Delete a bloque.
     */
    public function delete(int $id): bool
    {
        $bloque = $this->find($id);
        
        if (!$bloque) {
            return false;
        }

        return $bloque->delete();
    }

    /**
     * Get bloque with piezas pendientes.
     */
    public function getWithPiezasPendientes(int $id): ?Model
    {
        return $this->model
            ->with(['piezasPendientes'])
            ->find($id);
    }
}
