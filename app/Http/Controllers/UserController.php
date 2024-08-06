<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|confirmed|min:8', // Confirmación de la contraseña
            'role_id' => 'required|exists:roles,id',
            'status' => 'nullable|boolean',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->lastname = $request->lastname;
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

    public function update(Request $request){
        $userId = $request->id;
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'role_id' => 'required|exists:roles,id',
            'status' => 'nullable|boolean',
        ]);

        $user = User::findOrFail($userId);
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->save();

        // Asignar el rol
        $role = Role::findOrFail($request->role_id);
        $user->syncRoles($role); // Usa syncRoles si el rol puede cambiar

        // Redirigir con mensaje de éxito
        return redirect()->route('users.index')->with('success', 'Usuario actualizado con éxito.');
    }

    public function profileEdit($id){
        $user = User::find($id);
        $roles = Role::all();
        $dissabledStatus = true;
        $profileUpdate = true;
        return view('users.update', compact(['user', 'roles', 'dissabledStatus', 'profileUpdate']));
    }

    public function profileUpdate(Request $request){
        $userId = $request->id;
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($userId);
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->save();

        // Asignar el rol
        $role = Role::findOrFail($request->role_id);
        $user->syncRoles($role); // Usa syncRoles si el rol puede cambiar

        // Redirigir con mensaje de éxito
        return redirect()->route('home')->with('success', 'Usuario actualizado con éxito.');
    }
}
