<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'show users']);
        Permission::create(['name' => 'edit evento']);
        Permission::create(['name' => 'delete evento']);
        Permission::create(['name' => 'create evento']);
        Permission::create(['name' => 'show evento']);

        // Crear roles y asignar permisos
        $role = Role::create(['name' => 'organizer']);
        $role->givePermissionTo(
            'create evento',
            'edit evento',
            'delete evento',
            'show evento',
        );

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo([
            'create users',
            'edit users',
            'delete users',
            'show users',
            'create evento',
            'edit evento',
            'delete evento',
            'show evento',
        ]);

        $role = Role::create(['name' => 'assistant']);
    }
}
