<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\PiezaRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PiezaController extends Controller
{
    protected PiezaRepositoryInterface $piezaRepository;

    public function __construct(PiezaRepositoryInterface $piezaRepository)
    {
        $this->piezaRepository = $piezaRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        // Filtrar por bloque si se proporciona
        if ($request->has('bloque_id')) {
            if ($request->boolean('solo_pendientes')) {
                $piezas = $this->piezaRepository->getPendientesByBloque($request->bloque_id);
            } else {
                $piezas = $this->piezaRepository->getByBloque($request->bloque_id);
            }
        } elseif ($request->has('proyecto_id')) {
            $piezas = $this->piezaRepository->getByProyecto($request->proyecto_id);
        } else {
            $piezas = $this->piezaRepository->paginate($request->get('per_page', 15));
        }

        return response()->json([
            'success' => true,
            'data' => $piezas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'pieza' => 'required|string|max:10',
            'peso_teorico' => 'required|numeric|min:0',
            'proyecto_id' => 'required|exists:proyectos,id',
            'bloque_id' => 'required|exists:bloques,id',
            'descripcion' => 'nullable|string',
        ]);

        $validated['estado'] = 'Pendiente';
        
        $pieza = $this->piezaRepository->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pieza creada exitosamente',
            'data' => $pieza,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $pieza = $this->piezaRepository->find($id);

        if (!$pieza) {
            return response()->json([
                'success' => false,
                'message' => 'Pieza no encontrada',
            ], 404);
        }

        // Agregar diferencia de peso si existe peso_real
        $piezaArray = $pieza->toArray();
        $piezaArray['diferencia_peso'] = $pieza->diferencia_peso;

        return response()->json([
            'success' => true,
            'data' => $piezaArray,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'pieza' => 'sometimes|string|max:10',
            'peso_teorico' => 'sometimes|numeric|min:0',
            'peso_real' => 'nullable|numeric|min:0',
            'estado' => 'sometimes|in:Pendiente,Fabricado',
            'proyecto_id' => 'sometimes|exists:proyectos,id',
            'bloque_id' => 'sometimes|exists:bloques,id',
        ]);

        $updated = $this->piezaRepository->update($id, $validated);

        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'Pieza no encontrada',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pieza actualizada exitosamente',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->piezaRepository->delete($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Pieza no encontrada',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pieza eliminada exitosamente',
        ]);
    }

    /**
     * Register real weight and mark as fabricado.
     */
    public function registrarPeso(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'peso_real' => 'required|numeric|min:0',
        ]);

        $success = $this->piezaRepository->marcarComoFabricado(
            $id,
            $validated['peso_real'],
            Auth::id()
        );

        if (!$success) {
            return response()->json([
                'success' => false,
                'message' => 'Pieza no encontrada',
            ], 404);
        }

        $pieza = $this->piezaRepository->find($id);
        $piezaArray = $pieza->toArray();
        $piezaArray['diferencia_peso'] = $pieza->diferencia_peso;

        return response()->json([
            'success' => true,
            'message' => 'Peso registrado exitosamente',
            'data' => $piezaArray,
        ]);
    }

    /**
     * Get piezas pendientes agrupadas por proyecto.
     */
    public function pendientesPorProyecto(): JsonResponse
    {
        $piezasAgrupadas = $this->piezaRepository->getPendientesAgrupadasPorProyecto();

        $resultado = $piezasAgrupadas->map(function ($piezas, $proyectoId) {
            return [
                'proyecto' => $piezas->first()->proyecto,
                'total_pendientes' => $piezas->count(),
                'piezas' => $piezas,
            ];
        })->values();

        return response()->json([
            'success' => true,
            'data' => $resultado,
        ]);
    }
}
