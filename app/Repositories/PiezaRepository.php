<?php

namespace App\Repositories;

use App\Models\Pieza;
use App\Repositories\Contracts\PiezaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class PiezaRepository implements PiezaRepositoryInterface
{
    protected Model $model;

    public function __construct(Pieza $pieza)
    {
        $this->model = $pieza;
    }

    /**
     * Get all piezas.
     */
    public function all(): Collection
    {
        return $this->model->with(['proyecto', 'bloque', 'usuario'])->get();
    }

    /**
     * Find pieza by ID.
     */
    public function find(int $id): ?Model
    {
        return $this->model->with(['proyecto', 'bloque', 'usuario'])->find($id);
    }

    /**
     * Get piezas by bloque ID.
     */
    public function getByBloque(int $bloqueId): Collection
    {
        return $this->model
            ->where('bloque_id', $bloqueId)
            ->with(['proyecto', 'bloque'])
            ->get();
    }

    /**
     * Get piezas pendientes by bloque ID.
     */
    public function getPendientesByBloque(int $bloqueId): Collection
    {
        return $this->model
            ->where('bloque_id', $bloqueId)
            ->where('estado', 'Pendiente')
            ->orderBy('pieza')
            ->get();
    }

    /**
     * Get piezas by proyecto ID.
     */
    public function getByProyecto(int $proyectoId): Collection
    {
        return $this->model
            ->where('proyecto_id', $proyectoId)
            ->with(['bloque', 'usuario'])
            ->get();
    }

    /**
     * Create a new pieza.
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update a pieza.
     */
    public function update(int $id, array $data): bool
    {
        $pieza = $this->find($id);
        
        if (!$pieza) {
            return false;
        }

        return $pieza->update($data);
    }

    /**
     * Delete a pieza.
     */
    public function delete(int $id): bool
    {
        $pieza = $this->find($id);
        
        if (!$pieza) {
            return false;
        }

        return $pieza->delete();
    }

    /**
     * Mark pieza as fabricado.
     */
    public function marcarComoFabricado(int $id, float $pesoReal, int $usuarioId): bool
    {
        $pieza = $this->find($id);
        
        if (!$pieza) {
            return false;
        }

        return $pieza->marcarComoFabricado($pesoReal, $usuarioId);
    }

    /**
     * Get piezas with pagination.
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with(['proyecto', 'bloque', 'usuario'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get all piezas with pagination (alias)
     */
    public function getAllPaginated($perPage = 15)
    {
        return $this->paginate($perPage);
    }

    /**
     * Get piezas pendientes agrupadas por proyecto.
     */
    public function getPendientesAgrupadasPorProyecto(): Collection
    {
        return $this->model
            ->where('estado', 'Pendiente')
            ->with(['proyecto', 'bloque'])
            ->get()
            ->groupBy('proyecto_id');
    }
}
