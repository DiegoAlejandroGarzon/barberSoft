<?php

namespace App\Http\Controllers;

use App\Models\Barberia;
use App\Models\Barbero;
use App\Models\Departament;
use App\Models\Department;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las barberías
        $empresas = Empresa::all(); // O puedes usar paginate() para paginar

        // Retornar la vista con los datos
        return view('barberia.index', compact('empresas'));
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
            'color_one' => 'nullable|string|max:7', // HEX color format
            'color_two' => 'nullable|string|max:7', // HEX color format
        ]);

        // Subir el logo si existe
        if ($request->hasFile('logo')) {
            // Obtener el archivo
            $logo = $request->file('logo');

            // Obtener el nombre original del archivo
            $extension = $logo->getClientOriginalExtension();

            // Crear un nombre único para el archivo basado en el nombre de la barbería y la fecha
            $fileName = strtolower(str_replace(' ', '_', $request->input('name'))) . '-' . now()->format('Y-m-d_H-i-s') . '.' . $extension;

            // Guardar el archivo en la carpeta empresas/logos
            $logoPath = $logo->storeAs('empresas/logos', $fileName, 'public');
        } else {
            $logoPath = null;
        }

        // Crear la nueva barbería
        Empresa::create([
            'nombre' => $validated['nombre'],
            'ubicacion' => $validated['ubicacion'] ?? null,
            'contacto' => $validated['contacto'] ?? null,
            'status' => $validated['status'],
            'logo' => $logoPath,
            'guid' => Str::uuid(),
            'color_one' => $validated['color_one'],
            'color_two' => $validated['color_two'],
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
        $barberia = Empresa::find($id);

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
            'color_one' => 'nullable|string|max:7', // HEX color format
            'color_two' => 'nullable|string|max:7', // HEX color format
        ]);

        // Encontrar la barbería por su ID
        $barberia = Empresa::findOrFail($id);

        // Si hay un nuevo logo, lo subimos
        if ($request->hasFile('logo')) {
            // Eliminar el logo anterior si existe
            if ($barberia->logo) {
                Storage::disk('public')->delete($barberia->logo);
            }

            // Reemplazar los espacios en el nombre de la barbería con guiones bajos
            $fileName = strtolower(str_replace(' ', '_', $request->nombre)) . '-' . now()->format('Y-m-d_H-i-s') . '.' . $request->logo->extension();
            $logoPath = $request->file('logo')->storeAs('empresas/logos', $fileName, 'public');
        } else {
            // Si no se sube un nuevo logo, mantenemos el logo actual
            $logoPath = $barberia->logo;
        }
        // Actualizar la barbería
        $barberia->update([
            'nombre' => $request->nombre,
            'logo' => $logoPath,
            'color_one' => $request->color_one,
            'color_two' => $request->color_two,
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
        $barberia = Empresa::find($id);

        // Si no se encuentra la barbería, redirigir con un mensaje de error
        if (!$barberia) {
            return redirect()->route('barberia.index')->with('error', 'La barbería no fue encontrada.');
        }

        // Eliminar la barbería
        $barberia->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('barberia.index')->with('success', 'La barbería ha sido eliminada con éxito.');
    }

    public function registerPublic($guid){
        $barberia = Empresa::where('guid', $guid)->first();
        if (!$barberia) {
            return abort(404, 'Barbería no encontrada.');
        }

        // Obtener los empleados relacionados con la barbería
        $empleados = Empleado::whereHas('user', function ($query) use ($barberia) {
            $query->where('empresa_id', $barberia->id);
        })->get();
        return view('barberia.registerPublic', compact('barberia', 'empleados'));
    }
}
