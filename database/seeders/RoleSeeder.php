<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleInvitado = Role::create(['name' => 'invitado']);

        Permission::create(['name' => 'admin.recetas.create'])->syncRoles([$roleAdmin,$roleInvitado]);
        Permission::create(['name' => 'admin.recetas.edit'])->syncRoles([$roleAdmin,$roleInvitado]);
        Permission::create(['name' => 'admin.recetas.destroy'])->syncRoles([$roleAdmin,$roleInvitado]);




    }
}
