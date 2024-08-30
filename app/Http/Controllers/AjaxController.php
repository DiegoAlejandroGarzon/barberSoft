<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;


class AjaxController extends Controller
{
    //
  

    public function index()
    {
        $roles = Role::all();
        $cities = City::all(); // Obtener los departamentos
        $cities=DB::table('cities')->paginate(30);
        return view('search-form',compact(['roles', 'cities']));
    }

    public function searchAutocomplete(Request $request)
    {
        $res = City::select("name")
                ->where("name","LIKE","%{$request->term}%")
                ->get();
   
        return response()->json($res);
    }


    public function searchAutocompleteLayout(Request $request1)
    {
        $res = City::select("name")
                ->where("name","LIKE","%{$request1->term}%")
                ->get();
   
        return response()->json($res);
    }

    public function search(Request $query)
    {
        return City::select("name")
                ->where("name","LIKE","%{$query->term}%")
                ->get();
   
        
    }
}
