<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Crear roles
        $role1 = Role::firstOrCreate(['name' => 'ejecutivo']);
        $role2 = Role::firstOrCreate(['name' => 'general']);
        $role3 = Role::firstOrCreate(['name' => 'secretario']);
        $role4 = Role::firstOrCreate(['name' => 'vocal']);

        // Crear permisos y asignarlos a roles correspondientes
        // Ejecutivo
        Permission::create(['name' => 'ejecutivo.admin.user'])->syncRoles($role1);
        Permission::create(['name' => 'ejecutivo.admin.crear'])->syncRoles($role1);
        Permission::create(['name' => 'ejecutivo.admin.editar'])->syncRoles($role1);
        Permission::create(['name' => 'ejecutivo.admin.eliminar'])->syncRoles($role1);

        // General
        Permission::create(['name' => 'general.crear'])->syncRoles($role2);
        Permission::create(['name' => 'general.editar'])->syncRoles($role2);
        Permission::create(['name' => 'general.eliminar'])->syncRoles($role2);

        // Secretario
        Permission::create(['name' => 'secretario.crear'])->syncRoles($role3);
        Permission::create(['name' => 'secretario.editar'])->syncRoles($role3);

        // Vocal
        Permission::create(['name' => 'vocal'])->syncRoles($role4);
    }
}
