<?php

namespace App\Http\Controllers;

use App\Models\AdditionalParameter;
use App\Models\Departament;
use App\Models\Event;
use App\Models\EventAssistant;
use App\Models\TicketFeatures;
use App\Models\TicketType;
use App\Models\User;
use App\Models\UserEventParameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class EventController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        // $status = config('statusEvento.'.$search);
        // return $status;
        $eventos = Event::query()
            ->when($search, function ($query, $search) {
                $status = config('statusEvento.'.$search);
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                if($status){
                    $query
                    ->orWhere('status', 'like', "%{$status}%");
                }
            })
            ->paginate(10);
        return view('event.index', compact('eventos', 'search'));
    }

    public function create (){
        $departments = Departament::all();
        $features = TicketFeatures::all();
        return view('event.create', compact('departments', 'features'));
    }
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|max:255',
            'status' => 'required',
            'description' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'city_id' => 'required|integer|exists:cities,id',
            'event_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'header_image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ticketTypes.*.name' => 'required|string|max:255',
            'ticketTypes.*.capacity' => 'required|integer|min:1',
            'ticketTypes.*.price' => 'required|numeric',
            'ticketTypes.*.features' => 'required|array|exists:ticket_features,id',
            'additionalFields.*.label' => 'required|string|max:255',
            'additionalFields.*.value' => 'required|string|max:255',
        ]);

        // Manejar la carga de la imagen
        $imagePath = null;
        if ($request->hasFile('header_image_path')) {
            $image = $request->file('header_image_path');
            $imagePath = $image->store('event_images', 'public');
        }

        // Crear el evento
        $event = new Event();
        $event->name = $request->name;
        $event->description = $request->description;
        $event->capacity = $request->capacity;
        $event->city_id = $request->city_id;
        $event->event_date = $request->event_date;
        $event->start_time = $request->start_time;
        $event->end_time = $request->end_time;
        $event->address = $request->address;
        $event->header_image_path = $imagePath;
        $event->status = $request->status;
        // Convertir los campos adicionales a JSON
        if($request->input('additionalFields')){
            $event->additionalFields = json_encode($request->input('additionalFields', []));
        }

        // Guardar el ID del usuario que creó el evento
        $event->created_by = Auth::user()->id;
        $event->save();

        // Crear los tipos de entradas
        if($request->ticketTypes){
            foreach ($request->ticketTypes as $ticketTypeData) {
                $ticketType = $event->ticketTypes()->create([
                    'name' => $ticketTypeData['name'],
                    'capacity' => $ticketTypeData['capacity'],
                    'price' => $ticketTypeData['price'],
                ]);

                // Asignar características
                $ticketType->features()->sync($ticketTypeData['features']);
            }
        }

        return redirect()->route('event.index')->with('success', 'Evento creado exitosamente.');
    }

    public function edit($id){
        $event = Event::find($id);
        $departments = Departament::all();
        $features = TicketFeatures::all();
        return view('event.update', compact(['event', 'departments', 'features']));
    }

    public function update(Request $request){

        try {
            $id = $request->id;
            $event = Event::findOrFail($id);

            // Validar los datos de entrada
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'capacity' => 'required|integer|min:1',
                'header_image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'ticketTypes.*.name' => 'required|string|max:255',
                'ticketTypes.*.capacity' => 'required|integer|min:1',
                'ticketTypes.*.price' => 'required|numeric',
                'address' => 'required|max:255',
                'status' => 'required',
            ]);

            // Manejar la carga de la nueva imagen si se sube una
            if ($request->hasFile('header_image_path')) {
                if ($event->header_image_path) {
                    Storage::disk('public')->delete($event->header_image_path);
                }
                $image = $request->file('header_image_path');
                $event->header_image_path = $image->store('event_images', 'public');
            }

            // Actualizar el evento
            $event->name = $request->name;
            $event->description = $request->description;
            $event->capacity = $request->capacity;
            $event->city_id = $request->city_id;
            $event->event_date = $request->event_date;
            $event->start_time = $request->start_time;
            $event->end_time = $request->end_time;
            $event->address = $request->address;
            $event->status = $request->status;

            // Convertir los campos adicionales a JSON
            if($request->input('additionalFields')){
                $event->additionalFields = json_encode($request->input('additionalFields', []));
            }
            $event->save();

            // Obtener los IDs de los ticketTypes que vienen en la solicitud
            $newTicketTypeIds = collect($request->ticketTypes)->pluck('id')->filter()->all();

            // Eliminar los ticketTypes que no están en la solicitud y no están asociados con EventAssistants
            $event->ticketTypes()->whereNotIn('id', $newTicketTypeIds)->get()->each(function ($ticketType) {
                if ($ticketType->eventAssistants()->exists()) {
                    // Si el tipo de ticket está asociado a algún EventAssistant, no lo eliminamos y podríamos optar por otra lógica aquí
                    throw new \Exception("El tipo de ticket '{$ticketType->name}' no puede ser eliminado porque está asociado a un asistente.");
                }
                $ticketType->delete();
            });

            // Actualizar o crear nuevos ticketTypes
            foreach ($request->ticketTypes as $ticketTypeData) {
            $ticketType = TicketType::updateOrCreate(
                ['id' => $ticketTypeData['id'] ?? null, 'event_id' => $event->id],
                [
                    'name' => $ticketTypeData['name'],
                    'capacity' => $ticketTypeData['capacity'],
                    'price' => $ticketTypeData['price'],
                ]
            );

                // Asignar características
                $ticketType->features()->sync($ticketTypeData['features']);
            }

            return redirect()->route('event.index')->with('success', 'Evento actualizado exitosamente.');
        } catch (\Exception $e) {
            // Capturar la excepción y redirigir con un mensaje de error
            return redirect()->route('event.edit', $id)->with('error', $e->getMessage());
        }
    }

    public function generatePublicLink($id)
    {
        $event = Event::findOrFail($id);

        // Generar GUID único
        $guid = (string) Str::uuid();

        // Guardar el GUID en el evento
        $event->public_link = $guid;
        $event->save();

        // Devolver el enlace completo
        return redirect()->route('event.index')->with('success', 'Enlace público generado: ' . route('event.register', $guid));
    }

    public function showPublicRegistrationForm($public_link)
    {
        // Busca el evento por el enlace público
        $event = Event::where('public_link', $public_link)->firstOrFail();
        $additionalParameters = json_decode($event->additionalParameters, true) ?? [];
        $departments = Departament::all();

        // Retorna la vista de registro, pasando el evento
        return view('event.public_registration', compact('event', 'departments', 'additionalParameters'));
    }

    public function submitPublicRegistration(Request $request, $public_link)
    {
        $event = Event::where('public_link', $public_link)->firstOrFail();

        // $request = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|max:255',
        //     'type_document' => 'required|string|max:3',
        //     'document_number' => 'required|string|max:20|unique:users,document_number',
        // ]);

        // Buscar el usuario por correo electrónico, o crear uno nuevo si no existe
        $user = User::create(
            [
                'name' => $request['name'],
                'password' => Hash::make('12345678'), // Contraseña predeterminada
                'status' => false,
                'email' => $request['email'],
                'type_document' => $request['type_document'],
            ]
        );

        // Verificar si el usuario tiene el rol de 'assistant', si no, asignarlo
        if (!$user->hasRole('assistant')) {
            $assistantRole = Role::firstOrCreate(['name' => 'assistant']); // Crear el rol si no existe
            $user->assignRole($assistantRole);
        }

        // Crear el registro en la tabla `event_assistant` si no existe
        EventAssistant::firstOrCreate(
            [
                'event_id' => $event->id,
                'user_id' => $user->id,
            ],
            [
                'ticket_type_id' => null,
                'has_entered' => false,
            ]
        );

        // Obtener los parámetros adicionales definidos para el evento
        $definedParameters = AdditionalParameter::where('event_id', $event->id)->get();
        // Obtener las columnas definidas en $fillable del modelo User
        $userFillableColumns = (new User())->getFillable();
        // Detectar y almacenar parámetros adicionales enviados en el registro
        $additionalParameters = $request->except(array_merge(['_token'], $userFillableColumns)); // Excluir columnas del modelo User

        foreach ($definedParameters as $definedParameter) {
            if (isset($additionalParameters[$definedParameter->name])) {
                UserEventParameter::create([
                    'event_id' => $event->id,
                    'user_id' => $user->id,
                    'additional_parameter_id' => $definedParameter->id,
                    'value' => $additionalParameters[$definedParameter->name],
                ]);
            }
        }

        return redirect()->route('event.register', $public_link)->with('success', 'Inscripción exitosa.');
    }

    public function setRegistrationParameters($id)
    {
        $event = Event::findOrFail($id);
        $additional_parameters = AdditionalParameter::where('event_id', $id)->get();
        return view('event.set-registration-parameters', compact('event', 'additional_parameters'));
    }

    public function storeRegistrationParameters(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // Validar la entrada de los campos seleccionados
        $request->validate([
            'fields' => 'required|array',
            'fields.*' => 'in:name,lastname,email,type_document,document_number,phone,status,profile_photo_path,city_id,birth_date',
        ]);

        // Almacenar los campos seleccionados como parámetros de inscripción
        $parameters = json_encode($request->fields); // Convertir a JSON

        $event->registration_parameters = $parameters;
        $event->save();

        // Manejar los parámetros adicionales
        $additionalParameters = $request->input('additional_parameters', []);

        // Obtener los nombres de los parámetros adicionales enviados desde el formulario
        $newParameterNames = array_column($additionalParameters, 'name');

        // Obtener todos los parámetros adicionales actuales en la base de datos para este evento
        $existingParameters = AdditionalParameter::where('event_id', $event->id)->get();

        // Eliminar los parámetros adicionales que ya no están presentes en los nuevos datos enviados
        foreach ($existingParameters as $existingParameter) {
            if (!in_array($existingParameter->name, $newParameterNames)) {
                $existingParameter->delete();
            }

            // Agregar o actualizar los parámetros adicionales
            foreach ($additionalParameters as $param) {
                if (!empty($param['name']) && !empty($param['type'])) {
                    // Verificar si ya existe un parámetro adicional con el mismo 'name' y 'event_id'
                    $existingParameter = AdditionalParameter::where('event_id', $event->id)
                        ->where('name', $param['name'])
                        ->first();

                    if ($existingParameter) {
                        $existingParameter->update([
                            'type' => $param['type']
                        ]);
                    } else {
                        AdditionalParameter::create([
                            'event_id' => $event->id,
                            'name' => $param['name'],
                            'type' => $param['type']
                        ]);
                    }
                }
            }
        }
        return redirect()->route('event.index')->with('success', 'Parámetros de inscripción guardados correctamente.');
    }
}
