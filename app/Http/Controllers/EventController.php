<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'header_image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'additionalFields.*.label' => 'required_with:additionalFields|string|max:255',
            'additionalFields.*.value' => 'required_with:additionalFields|string|max:255',
        ]);

        // Manejar la carga de la imagen
        if ($request->hasFile('header_image_path')) {
            $image = $request->file('header_image_path');
            $imagePath = $image->store('event_images', 'public'); // Almacena la imagen en storage/app/public/event_images
        }

        // Crear el evento
        $event = new Event();
        $event->name = $request->input('name');
        $event->description = $request->input('description');
        $event->header_image_path = $imagePath; // Almacenar la ruta de la imagen
        $event->description = $request->input('description');
        $event->additionalFields = json_encode($request->input('additionalFields'));
        $event->created_by = Auth::user()->id;
        $event->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('event.index')->with('success', 'Evento creado exitosamente.');
    }

}
