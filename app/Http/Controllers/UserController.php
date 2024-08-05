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
}
