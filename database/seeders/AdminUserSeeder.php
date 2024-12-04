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
        $admin = User::create([
            'name' => 'Admin',
            'lastname' => 'Super-Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('12345678'),
            'status' => true,
        ]);
        $role = Role::firstOrCreate(['name' => 'super-admin']);
        $admin->assignRole($role);

    }
}
