<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\BloqueRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BloqueController extends Controller
{
    protected BloqueRepositoryInterface $bloqueRepository;

    public function __construct(BloqueRepositoryInterface $bloqueRepository)
    {
        $this->bloqueRepository = $bloqueRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        // Si se pasa proyecto_id, filtrar por proyecto
        if ($request->has('proyecto_id')) {
            $bloques = $this->bloqueRepository->getByProyecto($request->proyecto_id);
        } else {
            $bloques = $this->bloqueRepository->all();
        }

        return response()->json([
            'success' => true,
            'data' => $bloques,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nombre_bloque' => 'required|string|max:10',
            'proyecto_id' => 'required|exists:proyectos,id',
            'descripcion' => 'nullable|string',
        ]);

        $bloque = $this->bloqueRepository->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Bloque creado exitosamente',
            'data' => $bloque,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $bloque = $this->bloqueRepository->getWithPiezasPendientes($id);

        if (!$bloque) {
            return response()->json([
                'success' => false,
                'message' => 'Bloque no encontrado',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $bloque,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'nombre_bloque' => 'sometimes|string|max:10',
            'proyecto_id' => 'sometimes|exists:proyectos,id',
            'descripcion' => 'nullable|string',
        ]);

        $updated = $this->bloqueRepository->update($id, $validated);

        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'Bloque no encontrado',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Bloque actualizado exitosamente',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->bloqueRepository->delete($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Bloque no encontrado',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Bloque eliminado exitosamente',
        ]);
    }
}
