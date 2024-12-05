<?php

namespace App\Http\Controllers;

use App\Models\Barberia;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicios = Servicio::all();
        return view('servicio.index', compact(['servicios']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barberias = Barberia::all();
        return view('servicio.create', compact(['barberias']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|integer|min:0',
            'descripcion' => 'required|string|max:255',
            'barberia_id' => 'nullable|exists:barberias,id',
        ]);

        Servicio::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'barberia_id' => $request->barberia_id ?? Auth::user()->barberia_id,
        ]);

        return redirect()->route('servicio.index')->with('success', 'Servicio creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $servicio = Servicio::findOrFail($id);
        $barberias = Barberia::all();
        return view('servicio.update', compact('servicio', 'barberias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:1000',
            'barberia_id' => 'nullable|exists:barberias,id',
        ]);

        // Encontrar el servicio a actualizar
        $servicio = Servicio::findOrFail($id);

        // Actualizar los datos del servicio
        $servicio->update([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'barberia_id' => $request->barberia_id ?? Auth::user()->barberia_id,
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()
            ->route('servicio.index') // Cambia a la ruta de listado según corresponda
            ->with('success', 'Servicio actualizado exitosamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscar la barbería por su ID
        $servicio = Servicio::find($id);

        // Si no se encuentra la barbería, redirigir con un mensaje de error
        if (!$servicio) {
            return redirect()->route('servicio.index')->with('error', 'El Servicio no fue encontrado.');
        }

        // Eliminar la barbería
        $servicio->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('servicio.index')->with('success', 'El Servicio ha sido eliminado con éxito.');
    }
}
