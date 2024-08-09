<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function getCitiesByDepartment($departmentId)
    {
        // Obtén las ciudades correspondientes al departamento
        $cities = City::where('department_id', $departmentId)->get();

        // Devuelve los datos en el formato esperado
        return response()->json(['cities' => $cities]);
    }
}
