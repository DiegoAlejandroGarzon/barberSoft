<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Empleado;
use App\Models\Departament;
use App\Models\Department;
use App\Models\Servicio;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */public function index(Request $request)
    {
        // Obtener el término de búsqueda
        $search = $request->input('search');

        // Obtener todas las Empresas con búsqueda y paginación
        $empresas = Empresa::when($search, function ($query, $search) {
                return $query->where('nombre', 'like', "%{$search}%");
            })
            ->paginate(10); // Cambia el número de elementos por página según lo necesites

        // Retornar la vista con los datos
        return view('empresa.index', compact('empresas', 'search'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        $roles = Role::all();
        $departments = Departament::all(); // Obtener los departamentos

        return view('empresa.create', compact(['roles', 'departments']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos recibidos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'etiqueta_empleado' => 'required|string|max:255',
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

            // Crear un nombre único para el archivo basado en el nombre de la empresa y la fecha
            $fileName = strtolower(str_replace(' ', '_', $request->input('name'))) . '-' . now()->format('Y-m-d_H-i-s') . '.' . $extension;

            // Guardar el archivo en la carpeta empresas/logos
            $logoPath = $logo->storeAs('empresas/logos', $fileName, 'public');
        } else {
            $logoPath = null;
        }

        // Crear la nueva empresa
        Empresa::create([
            'nombre' => $validated['nombre'],
            'etiqueta_empleado' => $validated['etiqueta_empleado'],
            'ubicacion' => $validated['ubicacion'] ?? null,
            'contacto' => $validated['contacto'] ?? null,
            'status' => $validated['status'],
            'logo' => $logoPath,
            'guid' => Str::uuid(),
            'color_one' => $validated['color_one'],
            'color_two' => $validated['color_two'],
        ]);

        // Redirigir con éxito
        return redirect()->route('empresa.index')->with('success', 'empresa creada exitosamente');
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
        $empresa = Empresa::find($id);

        return view('empresa.update', compact(['empresa']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos recibidos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'etiqueta_empleado' => 'required|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'contacto' => 'nullable|string|max:20',
            'status' => 'required|boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'color_one' => 'nullable|string|max:7', // HEX color format
            'color_two' => 'nullable|string|max:7', // HEX color format
        ]);

        // Encontrar la empresa por su ID
        $empresa = Empresa::findOrFail($id);

        // Si hay un nuevo logo, lo subimos
        if ($request->hasFile('logo')) {
            // Eliminar el logo anterior si existe
            if ($empresa->logo) {
                Storage::disk('public')->delete($empresa->logo);
            }

            // Reemplazar los espacios en el nombre de la empresa con guiones bajos
            $fileName = strtolower(str_replace(' ', '_', $request->nombre)) . '-' . now()->format('Y-m-d_H-i-s') . '.' . $request->logo->extension();
            $logoPath = $request->file('logo')->storeAs('empresas/logos', $fileName, 'public');
        } else {
            // Si no se sube un nuevo logo, mantenemos el logo actual
            $logoPath = $empresa->logo;
        }
        // Actualizar la empresa
        $empresa->update([
            'nombre' => $validated['nombre'],
            'etiqueta_empleado' => $validated['etiqueta_empleado'],
            'ubicacion' => $validated['ubicacion'] ?? null,
            'contacto' => $validated['contacto'] ?? null,
            'status' => $validated['status'],
            'logo' => $logoPath,
            'color_one' => $validated['color_one'],
            'color_two' => $validated['color_two'],
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('empresa.index')->with('success', 'empresa actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscar la empresa por su ID
        $empresa = Empresa::find($id);

        // Si no se encuentra la empresa, redirigir con un mensaje de error
        if (!$empresa) {
            return redirect()->route('empresa.index')->with('error', 'La empresa no fue encontrada.');
        }

        // Eliminar la empresa
        $empresa->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('empresa.index')->with('success', 'La empresa ha sido eliminada con éxito.');
    }

    public function registerPublic($guid){
        $empresa = Empresa::where('guid', $guid)->first();
        if (!$empresa) {
            return abort(404, 'empresa no encontrada.');
        }

        // Obtener los empleados relacionados con la empresa
        $empleados = Empleado::whereHas('user', function ($query) use ($empresa) {
            $query->where('empresa_id', $empresa->id);
        })->get();

        // Obtener los empleados relacionados con la empresa
        $servicios = Servicio::where('empresa_id', $empresa->id)->get();
        return view('empresa.registerCitaPublic', compact('empresa', 'empleados', 'servicios'));
        return view('empresa.registerPublic', compact('empresa', 'empleados'));
    }
}
