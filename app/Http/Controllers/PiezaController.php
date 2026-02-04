<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\PiezaRepositoryInterface;
use App\Repositories\Contracts\ProyectoRepositoryInterface;
use App\Repositories\Contracts\BloqueRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PiezaController extends Controller
{
    protected PiezaRepositoryInterface $piezaRepository;
    protected ProyectoRepositoryInterface $proyectoRepository;
    protected BloqueRepositoryInterface $bloqueRepository;

    public function __construct(
        PiezaRepositoryInterface $piezaRepository,
        ProyectoRepositoryInterface $proyectoRepository,
        BloqueRepositoryInterface $bloqueRepository
    ) {
        $this->piezaRepository = $piezaRepository;
        $this->proyectoRepository = $proyectoRepository;
        $this->bloqueRepository = $bloqueRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // API requests
        if ($request->expectsJson()) {
            if ($request->has('bloque_id')) {
                if ($request->boolean('solo_pendientes')) {
                    $piezas = $this->piezaRepository->getPendientesByBloque($request->bloque_id);
                } else {
                    $piezas = $this->piezaRepository->getByBloque($request->bloque_id);
                }
            } elseif ($request->has('proyecto_id')) {
                $piezas = $this->piezaRepository->getByProyecto($request->proyecto_id);
            } else {
                $piezas = $this->piezaRepository->all();
            }
            return response()->json($piezas);
        }

        // Web view
        $piezas = $this->piezaRepository->getAllPaginated();
        return view('piezas.index', compact('piezas'));
    }

    /**
     * Show form for creating a new resource.
     */
    public function create(): View
    {
        $proyectos = $this->proyectoRepository->all();
        $bloques = $this->bloqueRepository->all();
        return view('piezas.create', compact('proyectos', 'bloques'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pieza' => 'required|string|max:10',
            'peso_teorico' => 'required|numeric|min:0',
            'peso_real' => 'nullable|numeric|min:0',
            'proyecto_id' => 'required|exists:proyectos,id',
            'bloque_id' => 'required|exists:bloques,id',
            'estado' => 'required|in:Pendiente,Fabricado',
        ]);

        if (!isset($validated['estado'])) {
            $validated['estado'] = 'Pendiente';
        }

        // Si tiene peso real y está marcado como fabricado, registrar usuario
        if ($validated['peso_real'] && $validated['estado'] === 'Fabricado') {
            $validated['registrado_por'] = Auth::id();
            $validated['fecha_registro'] = now();
        }
        
        $pieza = $this->piezaRepository->create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pieza creada exitosamente',
                'data' => $pieza,
            ], 201);
        }

        return redirect()->route('piezas.index')->with('success', 'Pieza creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $pieza = $this->piezaRepository->find($id);

        if (!$pieza) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Pieza no encontrada'], 404);
            }
            abort(404);
        }

        $pieza->load(['proyecto', 'bloque', 'usuario']);

        if (request()->expectsJson()) {
            $piezaArray = $pieza->toArray();
            $piezaArray['diferencia_peso'] = $pieza->diferencia_peso;
            return response()->json(['success' => true, 'data' => $piezaArray]);
        }

        return view('piezas.show', compact('pieza'));
    }

    /**
     * Show form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $pieza = $this->piezaRepository->find($id);
        
        if (!$pieza) {
            abort(404);
        }

        $proyectos = $this->proyectoRepository->all();
        $bloques = $this->bloqueRepository->all();
        return view('piezas.edit', compact('pieza', 'proyectos', 'bloques'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
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
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pieza no encontrada',
                ], 404);
            }
            return redirect()->route('piezas.index')->with('error', 'Pieza no encontrada');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pieza actualizada exitosamente',
            ]);
        }

        return redirect()->route('piezas.index')->with('success', 'Pieza actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $deleted = $this->piezaRepository->delete($id);

        if (!$deleted) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pieza no encontrada',
                ], 404);
            }
            return redirect()->route('piezas.index')->with('error', 'Pieza no encontrada');
        }

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pieza eliminada exitosamente',
            ]);
        }

        return redirect()->route('piezas.index')->with('success', 'Pieza eliminada exitosamente');
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
                'codigo' => $piezas->first()->proyecto->codigo,
                'nombre' => $piezas->first()->proyecto->nombre,
                'total_pendientes' => $piezas->count(),
                'piezas' => $piezas,
                'peso_total' => $piezas->sum('peso_teorico'),
            ];
        })->values();

        return response()->json($resultado);
    }

    /**
     * Mostrar formulario de registro de peso
     */
    public function formulario()
    {
        return view('piezas.formulario');
    }

    /**
     * Mostrar reporte de piezas pendientes
     */
    public function reporte()
    {
        $piezasPorProyecto = $this->piezaRepository->getPendientesAgrupadasPorProyecto()->map(function ($piezas, $proyectoId) {
            return [
                'codigo' => $piezas->first()->proyecto->codigo,
                'nombre' => $piezas->first()->proyecto->nombre,
                'total_pendientes' => $piezas->count(),
                'piezas' => $piezas,
                'peso_total' => $piezas->sum('peso_teorico'),
            ];
        })->values()->toArray();

        return view('piezas.reporte', compact('piezasPorProyecto'));
    }
}
