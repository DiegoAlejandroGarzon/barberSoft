<?php

namespace App\Http\Controllers;
use App\Models\ticket_features;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\TicketFeatures;
use Spatie\Permission\Models\Role;
use Illuminate\View\View;

class TicketFeatureController extends Controller
{
    //
    public function index():view{
        
        $roles = Role::all();
        $query = TicketFeatures::query();

        $featuredCategories = TicketFeatures::featured()->get();
        $products = TicketType::whereIn('ticket_feature_id', $featuredCategories->pluck('id'))->get();
        $products = Product::whereIn('ticket_feature_id', TicketFeatures::select('id')->featured())->get();

        if (request('search')) {
            $query
                ->where('name', 'like', '%' . request('search') . '%');
        }
                // Obtener los departamentos
        $tickets=$query->paginate(30);
        return view('ticketFeatures.index',compact(['roles', 'tickets']));

    }

    public function create(){

        $tickets=TicketFeatures::all();
        $roles = Role::all();
        return view('ticketFeatures.create',compact(['roles', 'tickets']));


    }


    public function edit($id){

        $ticket = TicketFeatures::find($id);
        $roles = Role::all();
        return view('ticketFeatures.update', compact(['roles', 'ticket']));
        

    }

    public function store(Request $request){

        $request->validate([
            
            'name' => 'required|string|max:255'
                       
        ]);

        $ticketFeatures = new TicketFeatures();
        $ticketFeatures->name = $request->name;
        $ticketFeatures->save();

        $roles = Role::all();
        $tickets = TicketFeatures::all();
        return view('ticketFeatures.index',compact(['roles', 'tickets']));


    }

    public function update(Request $request){

        $ticketid = $request->id;
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        
        $tickets = TicketFeatures::findOrFail($ticketid);
        $tickets->name = $request->name;
    
        $tickets->save();

        $roles = Role::all();
        $tickets = TicketFeatures::all();
        return view('ticketFeatures.index',compact(['roles', 'tickets']));


    }

    public function delete($id){

        $ticket=TicketFeatures::find($id);
        if (!$ticket)
        {   $data=[
                'message'=>'Ticket no no Encontrado',
                'status'=>404
                    
               ];
            return redirect()->route('ticketFeatures.index')->with('404', 'Ticket no no Encontrado');
            };
            $ticket->delete();

           
        $data=[
            'message'=>'ticket Eliminada',
            'status'=>201
        ];
        return redirect()->route('ticketFeatures.index')->with('201', 'Ticket Eliminado');
        $roles = Role::all();
        $tickets = TicketFeatures::all(); // Obtener las ciudades
        return view('ticketFeatures.index', compact(['roles', 'tickets']));
        }

}
