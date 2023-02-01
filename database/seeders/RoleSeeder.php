<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Creador']);

        Permission::create(['name' => 'admin.recetas.create'])->assignRole($role1);
        Permission::create(['name' => 'admin.recetas.edit'])->assignRole($role1);
        Permission::create(['name' => 'admin.recetas.destroy']) ->assignRole($role1);




    }
}
