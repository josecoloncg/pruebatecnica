<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\BloqueRepositoryInterface;
use App\Repositories\Contracts\ProyectoRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BloqueController extends Controller
{
    protected BloqueRepositoryInterface $bloqueRepository;
    protected ProyectoRepositoryInterface $proyectoRepository;

    public function __construct(
        BloqueRepositoryInterface $bloqueRepository,
        ProyectoRepositoryInterface $proyectoRepository
    ) {
        $this->bloqueRepository = $bloqueRepository;
        $this->proyectoRepository = $proyectoRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // API request
        if ($request->expectsJson()) {
            if ($request->has('proyecto_id')) {
                $bloques = $this->bloqueRepository->getByProyecto($request->proyecto_id);
            } else {
                $bloques = $this->bloqueRepository->all();
            }
            return response()->json($bloques);
        }

        // Web view con Inertia
        $bloques = $this->bloqueRepository->getAllPaginated(15);
        return Inertia::render('Bloques/Index', [
            'bloques' => $bloques
        ]);
    }

    /**
     * Show form for creating a new resource.
     */
    public function create(): Response
    {
        $proyectos = $this->proyectoRepository->all();
        return Inertia::render('Bloques/Create', [
            'proyectos' => $proyectos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_bloque' => 'required|string|max:50',
            'proyecto_id' => 'required|exists:proyectos,id',
            'descripcion' => 'nullable|string',
        ]);

        $bloque = $this->bloqueRepository->create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Bloque creado exitosamente',
                'data' => $bloque,
            ], 201);
        }

        return redirect()->route('bloques.index')->with('success', 'Bloque creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $bloque = $this->bloqueRepository->find($id);

        if (!$bloque) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Bloque no encontrado'], 404);
            }
            abort(404);
        }

        $bloque->load(['proyecto', 'piezas.usuario']);

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'data' => $bloque]);
        }

        // Redirigir a edit en lugar de show
        return redirect()->route('bloques.edit', $id);
    }

    /**
     * Show form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $bloque = $this->bloqueRepository->find($id);
        
        if (!$bloque) {
            abort(404);
        }

        $proyectos = $this->proyectoRepository->all();
        return Inertia::render('Bloques/Edit', [
            'bloque' => $bloque,
            'proyectos' => $proyectos
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'nombre_bloque' => 'sometimes|string|max:50',
            'proyecto_id' => 'sometimes|exists:proyectos,id',
            'descripcion' => 'nullable|string',
        ]);

        $updated = $this->bloqueRepository->update($id, $validated);

        if (!$updated) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Bloque no encontrado'], 404);
            }
            return redirect()->route('bloques.index')->with('error', 'Bloque no encontrado');
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Bloque actualizado exitosamente']);
        }

        return redirect()->route('bloques.index')->with('success', 'Bloque actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $deleted = $this->bloqueRepository->delete($id);

        if (!$deleted) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Bloque no encontrado'], 404);
            }
            return redirect()->route('bloques.index')->with('error', 'Bloque no encontrado');
        }

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Bloque eliminado exitosamente']);
        }

        return redirect()->route('bloques.index')->with('success', 'Bloque eliminado exitosamente');
    }
}
