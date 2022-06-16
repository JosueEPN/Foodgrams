<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::create([
            'name' => 'Styde',
            'email' => 'admin@styde.net',
            'nick_name'=> 'admin',
            'password' => bcrypt('secret')
        ]);

        $user->assignRole('admin');

        $user2 = \App\Models\User::create([
            'name' => 'Invitado',
            'email' => 'Invitado@hotmail.net',
            'nick_name'=> 'InviUser',
            'password' => bcrypt('secret')
        ]);

        $user2->assignRole('invitado');
    }
}
