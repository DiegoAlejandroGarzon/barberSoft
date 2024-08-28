<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function getCitiesByDepartment($departmentId)
    {
        // Obtén las ciudades correspondientes al departamento
        $cities = DepartCity::where('department_id', $departmentId)->get();

        // Devuelve los datos en el formato esperado
        return response()->json(['cities' => $cities]);
    }

    public function list(){
        $roles = Role::all();
        $departments = Department::all(); // Obtener los departamentos
        return view('department.index', compact(['roles', 'departments']));
    }


    public function create(){
        $roles = Role::all();
        return view('department.create', compact(['roles']));
    }

    public function store(Request $request){


        $request->validate([
            'code_dane' => 'required|string|max:255',
            'name' => 'required|string|max:255',            
        ]);

        $departamento = new Department();
        $departamento->code_dane = $request->code_dane;
        $departamento->name = $request->name;             
        $departamento->save();
        

        // Redirigir con mensaje de éxito
        return redirect()->route('department.index')->with('success', 'Departamento creado con éxito.');

        $roles = Role::all();
        $department = Department::all(); // Obtener los departamentos

        return view('department.index', compact(['roles', 'department']));
    }

    public function edit($id){
        $department = Department::find($id);
        $roles = Role::all();        
        return view('department.update', compact(['roles', 'department']));
        
    }

    public function update(Request $request){

        $departmentId = $request->id;
        $request->validate([
            'code_dane' => 'required|string|max:255',
            'name' => 'required|string|max:255',            
        ]);
        
        $department = Department::findOrFail($departmentId);
        $department->code_dane = $request->code_dane;
        $department->name = $request->name;

        $department->save();

        $roles = Role::all();
        $departments = Department::all(); // Obtener los departamentos
        return redirect()->route('department.index')->with('success', 'departemento actualizado con éxito.');
        return view('department.index', compact(['roles', 'departments']));
    }


    public function delete($id){
        
        $department=Department::find($id);
        if (!$department)
        {   $data=[
                'message'=>'Departamento no Encontrado',
                'status'=>404
                    
               ];
            return redirect()->route('department.index')->with('404', 'Departamento no Encontrado');   
            
        };

        $department->delete();

           
        $data=[
            'message'=>'Departamento Eliminado',
            'status'=>201
        ];
        return redirect()->route('department.index')->with('201', 'Departamento Eliminado'); 
        $roles = Role::all();
        $departments = Department::all(); // Obtener los departamentos
        return view('department.index', compact(['roles', 'departments']));
    }
}
