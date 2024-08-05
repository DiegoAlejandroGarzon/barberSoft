<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(){
        $usuarios = User::with('roles')->get();
        return view('users.index', compact(['usuarios']));
    }

    public function create(){
        $roles = Role::all();
        return view('users.create', compact(['roles']));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|confirmed|min:8', // Confirmación de la contraseña
            'role_id' => 'required|exists:roles,id',
            'status' => 'nullable|boolean',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->lastname = $request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->status = $request->status;
        $user->save();

        // Asignar el rol
        $role = Role::find($request->role_id);
        $user->assignRole($role);

        // Redirigir con mensaje de éxito
        return redirect()->route('users.index')->with('success', 'Usuario creado con éxito.');
    }

    public function edit($id){
        $user = User::find($id);
        $roles = Role::all();
        return view('users.update', compact(['user', 'roles']));
    }

    public function update($id){
        $user = User::find($id);
        $roles = Role::all();
        return view('users.update', compact(['user', 'roles']));
    }
}
