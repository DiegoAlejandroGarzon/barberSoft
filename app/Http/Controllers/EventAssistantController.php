<?php

namespace App\Http\Controllers;

use App\Imports\AssistantsImport;
use App\Models\Event;
use App\Models\EventAssistant;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EventAssistantController extends Controller
{
    public function index($idEvent){
        $asistentes = EventAssistant::where('event_id', $idEvent)->get();
        return view('eventAssistant.index', compact(['asistentes', 'idEvent']));
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
}
