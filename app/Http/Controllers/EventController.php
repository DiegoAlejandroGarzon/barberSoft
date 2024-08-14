<?php

namespace App\Http\Controllers;

use App\Models\Event;
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
        return view('event.create');
    }
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'header_image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ticketTypes.*.name' => 'required|string|max:255',
            'ticketTypes.*.capacity' => 'required|integer|min:1',
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
        $event->header_image_path = $imagePath;
        // Convertir los campos adicionales a JSON
        $event->additionalFields = json_encode($request->input('additionalFields', []));

        // Guardar el ID del usuario que creó el evento
        $event->created_by = Auth::user()->id;
        $event->save();

        // Crear los tipos de entradas
        foreach ($request->ticketTypes as $ticketType) {
            $event->ticketTypes()->create($ticketType);
        }

        return redirect()->route('event.index')->with('success', 'Evento creado exitosamente.');
    }

    public function edit($id){
        $event = Event::find($id);
        return view('event.update', compact(['event']));
    }

    public function update(Request $request){
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
        $event->additionalFields = json_encode($request->input('additionalFields'));
        $event->save();

        // Actualizar los tipos de entradas
        $event->ticketTypes()->delete();
        foreach ($request->ticketTypes as $ticketType) {
            $event->ticketTypes()->create($ticketType);
        }

        return redirect()->route('event.index')->with('success', 'Evento actualizado exitosamente.');
    }

}
