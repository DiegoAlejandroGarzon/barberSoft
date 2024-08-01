<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear el usuario administrador
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'), // Cambia esto por la contraseña que desees
        ]);

        // Crear el rol de admin si no existe
        $role = Role::firstOrCreate(['name' => 'admin']);

        // Asignar el rol de admin al usuario
        $admin->assignRole($role);
    }
}
