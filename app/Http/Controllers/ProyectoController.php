<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\ProyectoRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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
    public function index()
    {
        if (request()->expectsJson()) {
            $proyectos = $this->proyectoRepository->all();
            return response()->json($proyectos);
        }

        $proyectos = $this->proyectoRepository->getWithEstadisticas(null);
        return view('proyectos.index', compact('proyectos'));
    }

    /**
     * Show form for creating a new resource.
     */
    public function create(): View
    {
        return view('proyectos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:10|unique:proyectos,codigo',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
        ]);

        $proyecto = $this->proyectoRepository->create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Proyecto creado exitosamente',
                'data' => $proyecto,
            ], 201);
        }

        return redirect()->route('proyectos.index')->with('success', 'Proyecto creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $proyecto = $this->proyectoRepository->find($id);

        if (!$proyecto) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Proyecto no encontrado'], 404);
            }
            abort(404);
        }

        $proyecto->load(['bloques.piezas', 'piezas.bloque']);

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'data' => $proyecto]);
        }

        return view('proyectos.show', compact('proyecto'));
    }

    /**
     * Show form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $proyecto = $this->proyectoRepository->find($id);
        
        if (!$proyecto) {
            abort(404);
        }

        return view('proyectos.edit', compact('proyecto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'codigo' => 'sometimes|string|max:10|unique:proyectos,codigo,' . $id,
            'nombre' => 'sometimes|string|max:100',
            'descripcion' => 'nullable|string',
        ]);

        $updated = $this->proyectoRepository->update($id, $validated);

        if (!$updated) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Proyecto no encontrado'], 404);
            }
            return redirect()->route('proyectos.index')->with('error', 'Proyecto no encontrado');
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Proyecto actualizado exitosamente']);
        }

        return redirect()->route('proyectos.index')->with('success', 'Proyecto actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $deleted = $this->proyectoRepository->delete($id);

        if (!$deleted) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Proyecto no encontrado'], 404);
            }
            return redirect()->route('proyectos.index')->with('error', 'Proyecto no encontrado');
        }

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Proyecto eliminado exitosamente']);
        }

        return redirect()->route('proyectos.index')->with('success', 'Proyecto eliminado exitosamente');
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

        return response()->json($proyecto->bloques);
    }
}
