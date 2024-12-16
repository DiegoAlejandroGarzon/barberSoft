<?php

namespace App\Http\Controllers;

use App\Models\Barberia;
use App\Models\Barbero;
use App\Models\BarberoServicio;
use App\Models\Departament;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BarberoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barberos = Barbero::with('user')
            ->whereHas('user.roles', function ($query) {
                $query->where('name', 'barbero');
            })
            ->get();
        return view('barbero.index', compact('barberos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener todas las barberías para llenar el select
        $barberias = Barberia::all();
        $departments = Departament::all(); // Obtener los departamentos
        $servicios = Servicio::all();

        return view('barbero.create', compact('barberias', 'departments', 'servicios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'type_document' => 'required|in:CC,TI,CE,PAS',
            'document_number' => 'required|string|max:20|unique:users,document_number',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|max:15',
            'email' => 'required|email|unique:users,email',
            'barberia_id' => 'nullable|exists:barberias,id',
            'foto' => 'nullable|mimes:jpg,jpeg,png,gif|max:2048',
            'servicios' => 'nullable|array',
            'servicios.*' => 'exists:servicios,id', // Validar que los servicios existan
        ]);
        // Si el usuario autenticado no envía barberia_id, asignar la barbería del usuario autenticado
        if (is_null($request->barberia_id)) {
            $validatedData['barberia_id'] = auth()->user()->barberia_id ?? null;
        }

        // Generar una contraseña aleatoria
        $randomPassword = Str::random(10);

        // Crear el nuevo usuario
        $user = new User();
        $user->name = $validatedData['name'];
        $user->lastname = $validatedData['lastname'];
        $user->type_document = $validatedData['type_document'];
        $user->document_number = $validatedData['document_number'];
        $user->birth_date = $validatedData['birth_date'];
        $user->phone = $validatedData['phone'];
        $user->email = $validatedData['email'];
        $user->barberia_id = $validatedData['barberia_id'];
        $user->password = Hash::make($randomPassword);
        $user->status = true;

        $user->save();

        // Asignar rol al usuario
        $user->assignRole('barbero'); // Asegúrate de tener un rol por defecto si no se envía

        // Subir el logo si existe
        if ($request->hasFile('foto')) {
            // Obtener el archivo
            $logo = $request->file('foto');
            // Obtener el nombre original del archivo
            $extension = $logo->getClientOriginalExtension();
            // Crear un nombre único para el archivo basado en el nombre de la barbería y la fecha
            $fileName = $user->id. '-' . now()->format('Y-m-d_H-i-s') . '.' . $extension;
            // Guardar el archivo en la carpeta barberias/logos
            $fotoPath = $logo->storeAs('barberos/fotos', $fileName, 'public');
        } else {
            $fotoPath = null;
        }
        $barbero = new Barbero();
        $barbero->foto = $fotoPath;
        $barbero->usuario_id = $user->id;
        $barbero->save();

        // Agregar nuevos servicios
        $servicios = $validatedData['servicios'] ?? [];
        foreach ($servicios as $servicioId) {
            BarberoServicio::create([
                'barbero_id' => $barbero->id,
                'servicio_id' => $servicioId,
            ]);
        }

        return redirect()->route('barbero.index')->with('success', 'Usuario creado exitosamente.');
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
    public function edit($id)
    {
        $barbero = Barbero::findOrFail($id);
        $barberias = Barberia::all();
        $servicios = Servicio::all();
        return view('barbero.update', compact('barbero', 'barberias', 'servicios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $barbero = Barbero::find($id);
        // Buscar el usuario existente
        $user = User::findOrFail($barbero->usuario_id);
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'type_document' => 'required|in:CC,TI,CE,PAS',
            'document_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'document_number')->ignore($user->id),
            ],
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|max:15',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'barberia_id' => 'nullable|exists:barberias,id',
            'foto' => 'nullable|mimes:jpg,jpeg,png,gif|max:2048',
            'servicios' => 'nullable|array',
            'servicios.*' => 'exists:servicios,id', // Validar que los servicios existan
        ]);

        // Si el usuario autenticado no envía barberia_id, mantener la barbería actual
        if (is_null($request->barberia_id)) {
            $validatedData['barberia_id'] = $user->barberia_id;
        }

        // Actualizar los datos del usuario
        $user->name = $validatedData['name'];
        $user->lastname = $validatedData['lastname'];
        $user->type_document = $validatedData['type_document'];
        $user->document_number = $validatedData['document_number'];
        $user->birth_date = $validatedData['birth_date'];
        $user->phone = $validatedData['phone'];
        $user->email = $validatedData['email'];
        $user->barberia_id = $validatedData['barberia_id'];

        $user->save();

        // Manejar la actualización de la foto
        if ($request->hasFile('foto')) {
            // Eliminar la foto anterior si existe
            if ($barbero && $barbero->foto) {
                Storage::disk('public')->delete($barbero->foto);
            }

            // Subir la nueva foto
            $logo = $request->file('foto');
            $extension = $logo->getClientOriginalExtension();
            $fileName = $user->id . '-' . now()->format('Y-m-d_H-i-s') . '.' . $extension;
            $fotoPath = $logo->storeAs('barberos/fotos', $fileName, 'public');

            // Guardar la nueva foto
            if ($barbero) {
                $barbero->foto = $fotoPath;
                $barbero->save();
            }
        }
        // Sincronizar los servicios
        $servicios = $validatedData['servicios'] ?? [];
        $existingServicios = $barbero->servicios->pluck('id')->toArray();

        // Identificar los servicios a agregar y eliminar
        $toAdd = array_diff($servicios, $existingServicios);
        $toRemove = array_diff($existingServicios, $servicios);

        // Agregar nuevos servicios
        foreach ($toAdd as $servicioId) {
            BarberoServicio::create([
                'barbero_id' => $barbero->id,
                'servicio_id' => $servicioId,
            ]);
        }

        // Eliminar servicios que ya no están en la lista
        BarberoServicio::where('barbero_id', $barbero->id)
            ->whereIn('servicio_id', $toRemove)
            ->delete();

        return redirect()->route('barbero.index')->with('success', 'Usuario actualizado exitosamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscar la barbería por su ID
        $barbero = Barbero::find($id);

        // Si no se encuentra la barbería, redirigir con un mensaje de error
        if (!$barbero) {
            return redirect()->route('barberia.index')->with('error', 'La barbería no fue encontrada.');
        }

        // Eliminar la barbería
        $barbero->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('barberia.index')->with('success', 'La barbería ha sido eliminada con éxito.');
    }

    public function obtenerServicios($id)
    {
        $barbero = Barbero::find($id);

        if (!$barbero) {
            return response()->json(['success' => false, 'message' => 'Barbero no encontrado']);
        }

        $servicios = $barbero->servicios; // Asumiendo relación "services" en el modelo Barber
        return response()->json(['success' => true, 'servicios' => $servicios]);
    }
}
