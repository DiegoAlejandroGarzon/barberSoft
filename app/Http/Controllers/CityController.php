<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\Department;

class CityController extends Controller
{
    public function getCitiesByDepartment($departmentId)
    {
        // Obtén las ciudades correspondientes al departamento
        $cities = City::where('department_id', $departmentId)->get();

        // Devuelve los datos en el formato esperado
        return response()->json(['cities' => $cities]);
    }

    public function list():view{
        $roles = Role::all();
        $cities = City::all(); // Obtener los departamentos
        $cities=DB::table('cities')->paginate(30);
        #return view('city.index', ['cities'=> DB::table('cities')->paginate(15)]);
        return view('city.index', compact(['roles', 'cities']));
    }

  
    public function create(){
        $roles = Role::all();
        $departments = Department::all(); // Obtener los departamentos        
        return view('city.create', compact(['roles', 'departments']));
    }

    public function store(Request $request){


        $request->validate([
            'code_dane' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'provincia' => 'required|string|max:255' 
                       
        ]);

        $city = new City();
        $city->code_dane = $request->code_dane;
        $city->name = $request->name;
        $city->provincia = $request->provincia;
        $city->department_id = $request->department_id;            
        $city->save();
        

        // Redirigir con mensaje de éxito
        return redirect()->route('city.index')->with('success', 'ciudad creada con éxito.');

        $roles = Role::all();
        $city = City::all(); // Obtener los departamentos

        return view('city.index', compact(['roles', 'city']));
    }

    public function edit($id){
        $city = City::find($id);
        $departments = Department::all(); 
        $roles = Role::all();        
        return view('city.update', compact(['roles', 'city','departments']));
        
    }

    public function update(Request $request){

        $cityId = $request->id;
        $request->validate([
            'code_dane' => 'required|string|max:255',
            'name' => 'required|string|max:255', 
            'provincia' => 'required|string|max:255'          
        ]);
        
        $city = City::findOrFail($cityId);
        $city->code_dane = $request->code_dane;
        $city->name = $request->name;
        $city->provincia = $request->provincia;
        $city->department_id = $request->department_id;

        $city->save();

        $roles = Role::all();
        $city = City::all(); // Obtener los departamentos
        return redirect()->route('city.index')->with('success', 'ciudad actualizada con éxito.');
        return view('city.index', compact(['roles', 'city']));
    }


    public function delete($id){
        
        $city=City::find($id);
        if (!$city)
        {   $data=[
                'message'=>'Departamento no Encontrado',
                'status'=>404
                    
               ];
            return redirect()->route('city.index')->with('404', 'Departamento no Encontrado');   
            
        };

        $city->delete();

           
        $data=[
            'message'=>'Ciudad Eliminada',
            'status'=>201
        ];
        return redirect()->route('city.index')->with('201', 'Ciudad Eliminada'); 
        $roles = Role::all();
        $city = city::all(); // Obtener las ciudades
        return view('city.index', compact(['roles', 'city']));
    }

}
