<?php

namespace App\Repositories;

use App\Models\Proyecto;
use App\Repositories\Contracts\ProyectoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProyectoRepository implements ProyectoRepositoryInterface
{
    protected Model $model;

    public function __construct(Proyecto $proyecto)
    {
        $this->model = $proyecto;
    }

    /**
     * Get all proyectos.
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Find proyecto by ID.
     */
    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Find proyecto by codigo.
     */
    public function findByCodigo(string $codigo): ?Model
    {
        return $this->model->where('codigo', $codigo)->first();
    }

    /**
     * Create a new proyecto.
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update a proyecto.
     */
    public function update(int $id, array $data): bool
    {
        $proyecto = $this->find($id);
        
        if (!$proyecto) {
            return false;
        }

        return $proyecto->update($data);
    }

    /**
     * Delete a proyecto.
     */
    public function delete(int $id): bool
    {
        $proyecto = $this->find($id);
        
        if (!$proyecto) {
            return false;
        }

        return $proyecto->delete();
    }

    /**
     * Get proyecto with bloques.
     */
    public function getWithBloques(int $id): ?Model
    {
        return $this->model->with('bloques')->find($id);
    }

    /**
     * Get proyecto with estadisticas de piezas.
     */
    public function getWithEstadisticas($id = null)
    {
        $query = $this->model
            ->withCount([
                'bloques',
                'piezas',
                'piezas as piezas_pendientes_count' => function ($query) {
                    $query->where('estado', 'Pendiente');
                },
                'piezas as piezas_fabricadas_count' => function ($query) {
                    $query->where('estado', 'Fabricado');
                },
            ]);

        if ($id) {
            return $query->find($id);
        }

        return $query->paginate(15);
    }
}
