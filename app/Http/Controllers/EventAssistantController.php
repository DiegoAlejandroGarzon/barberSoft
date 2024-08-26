<?php

namespace App\Http\Controllers;

use App\Imports\AssistantsImport;
use App\Models\Event;
use App\Models\EventAssistant;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventAssistantController extends Controller
{
    public function index($idEvent){
        $event = Event::findOrFail($idEvent);

        // Número de asistentes registrados para el evento
        $totalTickets = EventAssistant::where('event_id', $idEvent)->where('has_entered', true)->count();

        // Capacidad total del evento
        $capacity = $event->capacity;

        // Calcula los datos para el gráfico
        $availableTickets = $capacity - $totalTickets;
        $data = [
            'soldTickets' => $totalTickets, // Entradas vendidas
            'availableTickets' => $availableTickets, // Entradas disponibles
            'capacity' => $capacity // Capacidad total
        ];
        $asistentes = EventAssistant::where('event_id', $idEvent)->get();
        return view('eventAssistant.index', compact(['asistentes', 'idEvent', 'data']));
    }

    // Muestra la vista para subir el archivo de Excel
    public function showMassAssign($idEvent)
    {
        $event = Event::findOrFail($idEvent);
        return view('eventAssistant.massAssign', compact('event'));
    }

    // Procesa el archivo de Excel y asigna los asistentes de forma masiva
    public function uploadMassAssign(Request $request, $idEvent)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048', // Validar que sea un archivo Excel
        ]);

        try {
            // Instanciar el importador y recolectar los datos de las importaciones
            $import = new AssistantsImport($idEvent);
            Excel::import($import, $request->file('file'));

            // Obtener los detalles de los usuarios agregados y las novedades
            $importedUsers = $import->getImportedUsers();
            $messages = $import->getMessages();

            return redirect()->route('eventAssistant.massAssign', $idEvent)
                            ->with('success', 'Asistentes asignados exitosamente.')
                            ->with('importedUsers', $importedUsers)
                            ->with('messages', $messages);
        } catch (\Exception $e) {
            return redirect()->route('eventAssistant.massAssign', $idEvent)
                            ->with('error', 'Hubo un error al procesar el archivo: ' . $e->getMessage());
        }
    }

    public function singleAssignForm($idEvent)
    {
        $assistants = User::whereHas('roles', function ($query) {
            $query->where('name', 'Assistant');
        })->get();
        $event = Event::findOrFail($idEvent);
        $ticketTypes  = TicketType::where('event_id', $idEvent)->get();
        return view('eventAssistant.singleAssign', compact('event', 'assistants', 'ticketTypes'));
    }

    public function uploadSingleAssign(Request $request, $eventId)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'ticketTypes' => 'nullable|array',
            'ticketTypes.*' => 'nullable|exists:ticket_types,id',
        ]);

        // Obtener el evento
        $event = Event::findOrFail($eventId);
        // return $request;
        foreach ($validatedData['ticketTypes'] as $userId => $ticketId) {
            // Buscar si ya existe un registro para este usuario y evento
            $eventAssistant = EventAssistant::where('event_id', $eventId)
                ->where('user_id', $userId)
                ->first();

            if ($eventAssistant) {
                // Actualizar el registro existente con el tipo de ticket seleccionado
                $eventAssistant->ticket_type_id = $validatedData['ticketTypes'][$userId] ?? null;
                $eventAssistant->save();
            } else {
                // Crear un nuevo registro
                EventAssistant::create([
                    'event_id' => $eventId,
                    'user_id' => $userId,
                    'ticket_type_id' => $validatedData['ticketTypes'][$ticketId] ?? null,
                    'has_entered' => false, // Asumimos que inicialmente el usuario no ha entrado al evento
                ]);
            }
        }

        // Redirigir con un mensaje de éxito
        return redirect()->route('eventAssistant.index', $eventId)
        ->with('success', 'Asistentes asignados exitosamente.');
    }

    public function showQr($id)
    {
        // Obtener el asistente por ID
        $asistente = EventAssistant::findOrFail($id);

        // Retornar una vista que muestre el QR
        return view('eventAssistant.qr', compact('asistente'));
    }

    public function infoQr($id)
    {
        // Buscar el asistente por su ID
        $eventAssistant = EventAssistant::findOrFail($id);

        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Obtener el usuario autenticado
            $user = Auth::user();

            // Verificar si el usuario tiene los roles 'admin' o 'organizer'
            if ($user->hasRole('admin') || $user->hasRole('organizer')) {
                // Redirigir a la vista con información completa
                return view('eventAssistant.qr.adminView', compact('eventAssistant'));
            } else {
                // Redirigir a la vista con información básica para usuarios autenticados que no tienen esos roles
                return view('eventAssistant.qr.basicAuthView', compact('eventAssistant'));
            }
        } else {
            // Redirigir a la vista con información básica para usuarios no autenticados
            return view('eventAssistant.qr.guestView', compact('eventAssistant'));
        }
    }

    public function registerEntry($id)
    {
        // Buscar el asistente por su ID
        $eventAssistant = EventAssistant::findOrFail($id);

        // Cambiar el estado de has_entered
        $eventAssistant->has_entered = true;
        $eventAssistant->save();

        // Redirigir de nuevo a la vista con un mensaje de éxito
        return redirect()->back()->with('success', 'Ingreso registrado correctamente.');
    }
}
