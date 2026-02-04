<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\ProyectoRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    protected ProyectoRepositoryInterface $proyectoRepository;

    public function __construct(ProyectoRepositoryInterface $proyectoRepository)
    {
        $this->proyectoRepository = $proyectoRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $proyectos = $this->proyectoRepository->all();
        
        return response()->json([
            'success' => true,
            'data' => $proyectos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:10|unique:proyectos,codigo',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
        ]);

        $proyecto = $this->proyectoRepository->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Proyecto creado exitosamente',
            'data' => $proyecto,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $proyecto = $this->proyectoRepository->getWithEstadisticas($id);

        if (!$proyecto) {
            return response()->json([
                'success' => false,
                'message' => 'Proyecto no encontrado',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $proyecto,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'codigo' => 'sometimes|string|max:10|unique:proyectos,codigo,' . $id,
            'nombre' => 'sometimes|string|max:100',
            'descripcion' => 'nullable|string',
        ]);

        $updated = $this->proyectoRepository->update($id, $validated);

        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'Proyecto no encontrado',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Proyecto actualizado exitosamente',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->proyectoRepository->delete($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Proyecto no encontrado',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Proyecto eliminado exitosamente',
        ]);
    }

    /**
     * Get bloques of a proyecto.
     */
    public function bloques(int $id): JsonResponse
    {
        $proyecto = $this->proyectoRepository->getWithBloques($id);

        if (!$proyecto) {
            return response()->json([
                'success' => false,
                'message' => 'Proyecto no encontrado',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $proyecto->bloques,
        ]);
    }
}
