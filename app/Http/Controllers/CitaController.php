<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $query = Cita::with(['cliente', 'empleado.user']);
        if (!$user->hasRole('super-admin')) {
            $query->whereHas('empleado.user', function ($query) use ($user) {
                $query->where('empresa_id', $user->empresa_id);
            });
        }
        $citas = $query->orderByRaw("
                CASE
                    WHEN estado = 'pendiente' THEN 1
                    WHEN estado IN ('completada', 'cancelada') THEN 2
                END,
                fecha_hora ASC
            ")->get();

        return view('citas.index', compact('citas'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::all();
        $empleados = Empleado::all();
        $servicios = Servicio::all();

        return view('citas.create', compact('clientes', 'empleados', 'servicios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validator = $request->validate([
            'tipo_documento'    => 'required|string|in:CC,TI',
            'numero_documento'  => 'required|string|max:20',
            'nombres'           => 'required|string|max:255',
            'apellidos'         => 'required|string|max:255',
            'telefono'          => 'nullable|string|max:20',
            'correo'            => 'nullable|email|max:255',
            'empleado_id'        => 'required|exists:empleados,id',
            'servicios'         => 'required|array',
            'servicios.*'       => 'exists:servicios,id',
            'fecha_hora'        => 'required|date',
        ]);

        // Verificar si ya existe una cita para el mismo empleado en la misma fecha y hora
        $citaExistente = Cita::where('empleado_id', $request->empleado_id)
            ->where('fecha_hora', $request->fecha_hora)
            ->first();

        if ($citaExistente) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Ya existe una cita para este empleado en esta fecha y hora.'])
                ->withInput();
        }

        // Buscar o crear el cliente
        $cliente = Cliente::firstOrCreate(
            [
                'tipo_documento'   => $request->tipo_documento,
                'numero_documento' => $request->numero_documento,
            ],
            [
                'nombres'   => $request->nombres,
                'apellidos' => $request->apellidos,
                'telefono'  => $request->telefono,
                'correo'    => $request->correo,
            ]
        );

        $cita = new Cita();
        $cita->cliente_id   = $cliente->id;
        $cita->empleado_empresa_id   = $request->empleado_empresa_id;
        $cita->fecha_hora   = $request->fecha_hora;
        $cita->save();

        // Asignar servicios a la cita (relación muchos a muchos)
        $cita->servicios()->attach($request->servicios);

        // Redirigir con mensaje de éxito
        return view('empresa.registeredPublic/'.$cita->guid, compact('cita'));
    }

    public function publicRegistered($guid)
    {
        $cita = Cita::where('guid', $guid)->firstOrFail();
        $empresa = $cita->empleado->user->empresa;
        $cliente = $cita->cliente;
        $empleado = $cita->empleado;

        // Generar la URL actual
        $url = url()->current();
        $qrCode = QrCode::size(200)->generate($url);

        return view('empresa.registeredPublic', compact('cita', 'empresa', 'cliente', 'empleado', 'qrCode'));
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
        // Encuentra la cita por su ID
        $cita = Cita::findOrFail($id);

        // Obtén la lista de empleados (relacionados a usuarios)
        $empleados = Empleado::with('user')->get();

        // Obtén los servicios relacionados a esta cita
        $serviciosSeleccionados = $cita->servicios()->pluck('servicios.id')->toArray();
        $servicios = Servicio::all();

        return view('citas.update', compact('cita', 'empleados', 'servicios', 'serviciosSeleccionados'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'tipo_documento' => 'required|string|max:2',
            'numero_documento' => 'required|string|max:20',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'correo' => 'required|email|max:255',
            'empleado_id' => 'required|exists:empleados,id',
            'servicios' => 'required|array',
            'servicios.*' => 'exists:servicios,id',
            'fecha_hora' => 'required|date',
        ]);

        // Verificar si ya existe una cita para el mismo empleado en la misma fecha y hora
        $citaExistente = Cita::where('empleado_id', $request->empleado_id)
            ->where('fecha_hora', $request->fecha_hora)
            ->first();

        if ($citaExistente) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Ya existe una cita para este empleado en esta fecha y hora.'])
                ->withInput();
        }

        // Buscar la cita
        $cita = Cita::findOrFail($id);

        // Buscar el cliente existente
        $cliente = Cliente::find($cita->cliente_id);

        if ($cliente) {
            // Actualizar cliente existente
            $cliente->update([
                'tipo_documento' => $request->tipo_documento,
                'numero_documento' => $request->numero_documento,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'telefono' => $request->telefono,
                'correo' => $request->correo,
            ]);
        } else {
            // Crear nuevo cliente (si no existiera)
            $cliente = Cliente::create([
                'tipo_documento' => $request->tipo_documento,
                'numero_documento' => $request->numero_documento,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'telefono' => $request->telefono,
                'correo' => $request->correo,
            ]);
        }

        // Actualizar datos de la cita
        $cita->update([
            'cliente_id' => $cliente->id,
            'empleado_id' => $request->empleado_id,
            'fecha_hora' => $request->fecha_hora,
        ]);

        // Sincronizar servicios
        $cita->servicios()->sync($request->servicios);

        return redirect()->route('citas.index')->with('success', 'Cita actualizada exitosamente.');
    }
    public function destroy(string $id)
    {
        //
    }

    public function citesDashBoard(Request $request)
    {
        // Validar la fecha proporcionada
        $request->validate([
            'date' => 'required|date',
        ]);

        $fecha = $request->date;

        // Traer las citas de la fecha específica, ordenadas por horario
        $citas = Cita::with(['cliente', 'empleado'])
            ->whereDate('fecha_hora', $fecha)
            ->orderBy('fecha_hora')
            ->get();

        // Generar una estructura para horarios (por ejemplo, de 8:00 a 18:00 cada media hora)
        $horarios = [];
        $horaInicio = Carbon::createFromTime(8, 0); // 8:00 AM
        $horaFin = Carbon::createFromTime(23, 0); // 6:00 PM

        while ($horaInicio < $horaFin) {
            $horarios[$horaInicio->format('H:i')] = []; // Inicialmente sin citas
            $horaInicio->addMinutes(60); // Intervalos de 30 minutos
        }

        // Asignar citas a sus horarios correspondientes
        foreach ($citas as $cita) {
            $hora = Carbon::parse($cita->fecha_hora)->format('H:i');
            if (isset($horarios[$hora])) {
                $horarios[$hora][] = $cita; // Asignar cita al horario correspondiente
            }
        }

        // Retornar vista con la información de horarios y citas
        return view('citas.dashboard', compact('fecha', 'horarios'));
    }
}
