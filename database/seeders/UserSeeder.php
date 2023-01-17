<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::create([
            'name' => 'Josue Singaña',
            'email' => 'Josuesin01122015@gmail.com',
            'nick_name' => 'Josin15',
            'email_verified_at' => now(),
            'password' => bcrypt('secret'), // password
            'remember_token' => Str::random(30),
        ])->assignRole('Admin');
        

        User::factory(10)->create();


    }
}
