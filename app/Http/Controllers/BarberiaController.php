<?php

namespace App\Http\Controllers;

use App\Models\Barberia;
use App\Models\Departament;
use App\Models\Department;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BarberiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las barberías
        $barberias = Barberia::all(); // O puedes usar paginate() para paginar

        // Retornar la vista con los datos
        return view('barberia.index', compact('barberias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        $roles = Role::all();
        $departments = Departament::all(); // Obtener los departamentos

        return view('barberia.create', compact(['roles', 'departments']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos recibidos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'contacto' => 'nullable|string|max:20',
            'status' => 'required|boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Subir el logo si existe
        if ($request->hasFile('logo')) {
            // Obtener el archivo
            $logo = $request->file('logo');

            // Obtener el nombre original del archivo
            $extension = $logo->getClientOriginalExtension();

            // Crear un nombre único para el archivo basado en el nombre de la barbería y la fecha
            $fileName = strtolower(str_replace(' ', '_', $request->input('name'))) . '-' . now()->format('Y-m-d_H-i-s') . '.' . $extension;

            // Guardar el archivo en la carpeta barberias/logos
            $logoPath = $logo->storeAs('barberias/logos', $fileName, 'public');
        } else {
            $logoPath = null;
        }

        // Crear la nueva barbería
        Barberia::create([
            'nombre' => $validated['nombre'],
            'ubicacion' => $validated['ubicacion'] ?? null,
            'contacto' => $validated['contacto'] ?? null,
            'status' => $validated['status'],
            'logo' => $logoPath,
        ]);

        // Redirigir con éxito
        return redirect()->route('barberia.index')->with('success', 'Barbería creada exitosamente');
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
        $barberia = Barberia::find($id);

        return view('barberia.update', compact(['barberia']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Encontrar la barbería por su ID
        $barberia = Barberia::findOrFail($id);

        // Si hay un nuevo logo, lo subimos
        if ($request->hasFile('logo')) {
            // Eliminar el logo anterior si existe
            if ($barberia->logo) {
                Storage::disk('public')->delete($barberia->logo);
            }

            // Reemplazar los espacios en el nombre de la barbería con guiones bajos
            $fileName = strtolower(str_replace(' ', '_', $request->nombre)) . '-' . now()->format('Y-m-d_H-i-s') . '.' . $request->logo->extension();
            $logoPath = $request->file('logo')->storeAs('barberias/logos', $fileName, 'public');
        } else {
            // Si no se sube un nuevo logo, mantenemos el logo actual
            $logoPath = $barberia->logo;
        }
        $barberia->guid = Str::uuid(); // Generar manualmente
        // Actualizar la barbería
        $barberia->update([
            'nombre' => $request->nombre,
            'logo' => $logoPath,
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('barberia.index')->with('success', 'Barbería actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscar la barbería por su ID
        $barberia = Barberia::find($id);

        // Si no se encuentra la barbería, redirigir con un mensaje de error
        if (!$barberia) {
            return redirect()->route('barberia.index')->with('error', 'La barbería no fue encontrada.');
        }

        // Eliminar la barbería
        $barberia->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('barberia.index')->with('success', 'La barbería ha sido eliminada con éxito.');
    }
}
