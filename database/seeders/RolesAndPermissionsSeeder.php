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
        // Crear permisos para los modelos
        Permission::create(['name' => 'create barberias']);
        Permission::create(['name' => 'edit barberias']);
        Permission::create(['name' => 'delete barberias']);
        Permission::create(['name' => 'show barberias']);

        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'show users']);

        Permission::create(['name' => 'create barberos']);
        Permission::create(['name' => 'edit barberos']);
        Permission::create(['name' => 'delete barberos']);
        Permission::create(['name' => 'show barberos']);

        Permission::create(['name' => 'create horarios']);
        Permission::create(['name' => 'edit horarios']);
        Permission::create(['name' => 'delete horarios']);
        Permission::create(['name' => 'show horarios']);

        Permission::create(['name' => 'create servicios']);
        Permission::create(['name' => 'edit servicios']);
        Permission::create(['name' => 'delete servicios']);
        Permission::create(['name' => 'show servicios']);

        Permission::create(['name' => 'create citas']);
        Permission::create(['name' => 'edit citas']);
        Permission::create(['name' => 'delete citas']);
        Permission::create(['name' => 'show citas']);

        Permission::create(['name' => 'create clientes']);
        Permission::create(['name' => 'edit clientes']);
        Permission::create(['name' => 'delete clientes']);
        Permission::create(['name' => 'show clientes']);

        // Crear el rol super-admin y asignarle los permisos
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo([
            'create barberias',
            'edit barberias',
            'delete barberias',
            'show barberias',
            'create users',
            'edit users',
            'delete users',
            'show users',
            'create barberos',
            'edit barberos',
            'delete barberos',
            'show barberos',
            'create horarios',
            'edit horarios',
            'delete horarios',
            'show horarios',
            'create servicios',
            'edit servicios',
            'delete servicios',
            'show servicios',
            'create citas',
            'edit citas',
            'delete citas',
            'show citas',
            'create clientes',
            'edit clientes',
            'delete clientes',
            'show clientes',
        ]);

        // Crear el rol admin y asignarle los permisos, sin los permisos sobre barberías y usuarios
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'create barberos',
            'edit barberos',
            'delete barberos',
            'show barberos',
            'create horarios',
            'edit horarios',
            'delete horarios',
            'show horarios',
            'create servicios',
            'edit servicios',
            'delete servicios',
            'show servicios',
            'create citas',
            'edit citas',
            'delete citas',
            'show citas',
            'create clientes',
            'edit clientes',
            'delete clientes',
            'show clientes',
        ]);


        $adminRole = Role::create(['name' => 'barbero']);
        $adminRole->givePermissionTo([
            'create servicios',
            'edit servicios',
            'delete servicios',
            'show servicios',
        ]);
        $adminRole = Role::create(['name' => 'cliente']);
        $adminRole->givePermissionTo([
            'create citas',
            'edit citas',
            'delete citas',
            'show citas',
        ]);
    }
}
