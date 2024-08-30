<?php

namespace App\Http\Controllers;

use App\Exports\TemplateExport;
use App\Imports\AssistantsImport;
use App\Models\Event;
use App\Models\EventAssistant;
use App\Models\FeatureConsumption;
use App\Models\TicketFeatures;
use App\Models\TicketType;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventAssistantController extends Controller
{
    public function index(Request $request, $idEvent){
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

        // Aplicar búsqueda y paginación
        $query = EventAssistant::where('event_id', $idEvent);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $asistentes = $query->paginate(10);

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
                    'ticket_type_id' => $validatedData['ticketTypes'][$userId] ?? null,
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
        $eventAssistant->entry_time = now();
        $eventAssistant->save();

        $event = $eventAssistant->event;
        $currentCount = EventAssistant::where('event_id', $event->id)
        ->where('has_entered', true)
        ->count();
        $successMessage = 'Ingreso registrado correctamente.';

        if ($currentCount >= $event->capacity) {
            // Redirigir con una alerta si se ha superado el aforo
            return redirect()->back()->with([
                'success' => $successMessage,
                'error' => 'Aforo máximo alcanzado o superado. Se han registrado '.$currentCount." entradas y la capacidad maximo es de ".$event->capacity,
            ]);
        }else{
            return redirect()->back()->with('success', $successMessage);
        }
    }

    public function rejectEntry($id)
    {
        // Buscar el asistente por su ID
        $eventAssistant = EventAssistant::findOrFail($id);

        // Cambiar el estado de rechazo
        $eventAssistant->rejected = true;
        $eventAssistant->rejected_time = now();
        $eventAssistant->save();

        // Redirigir de nuevo a la vista con un mensaje de rechazo
        return redirect()->back()->with('success', 'Ingreso rechazado correctamente.');
    }

    public function generatePDF($id)
    {
        $asistente = EventAssistant::with('user', 'event')->findOrFail($id);
        $evento = Event::find($asistente->event_id);

        // Generar QR code como base64
        $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($asistente->qrCode);

        $pdf = Pdf::loadView('pdf.assistant', compact('asistente', 'evento', 'qrCodeBase64'));

        //se muestra en una nueva ventana
        return $pdf->stream('asistente_'.$asistente->user->name.'_evento_'.$evento->name.'.pdf');
        // Se descarga,
        // return $pdf->download('Asistente_Evento_' . $asistente->user->name . '.pdf');
    }

    public function consumeFeature(EventAssistant $eventAssistant, $feature)
    {
        $eventAssistant = EventAssistant::find($eventAssistant)->first();
        // return $eventAssistant;
        $feature = TicketFeatures::find($feature);
        // return $feature->id;
        $featureConsumptions = FeatureConsumption::where('event_assistant_id', $eventAssistant->id)->where('ticket_feature_id', $feature->id)->get()->count();
        // Verificar si el feature es consumible y no ha sido consumido
        if (!$feature->consumable || $featureConsumptions > 0) {
            return redirect()->back()->with('error', 'El feature no es consumible o ya ha sido consumido.');
        }

        // Marcar el feature como consumido
        $featureConsumptions = new FeatureConsumption();
        $featureConsumptions->event_assistant_id = $eventAssistant->id;
        $featureConsumptions->ticket_feature_id = $feature->id;
        $featureConsumptions->consumed_at = now();
        $featureConsumptions->save();

        return redirect()->back()->with('success', 'El feature ha sido consumido exitosamente.');
    }

    public function downloadTemplate($id)
    {
        // Obtener los parámetros de inscripción (registration_parameters) del evento desde la base de datos
        $event = Event::findOrFail($id);

        // Decodificar los parámetros de inscripción de formato JSON a un array PHP
        $registration_parameters = json_decode($event->registration_parameters, true);

        // Si registration_parameters es nulo o vacío, usa un conjunto predeterminado
        if (empty($registration_parameters)) {
            $registration_parameters = [
                'name',
                'lastname',
                'email',
                'type_document',
                'document_number',
                'phone',
                'city_id',
                'birth_date',
            ];
        }

        // Crear una instancia de la exportación con los encabezados
        $export = new TemplateExport($registration_parameters);

        // Descargar el archivo Excel
        return Excel::download($export, 'plantilla_asistentes-'.$event->name.'.xlsx');
    }
}
