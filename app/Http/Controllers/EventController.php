<?php

namespace App\Http\Controllers;

use App\Models\Departament;
use App\Models\Event;
use App\Models\TicketFeatures;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{

    public function index(){
        $eventos = Event::get();
        return view('event.index', compact(['eventos']));
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
        $event->header_image_path = $imagePath;
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


}
