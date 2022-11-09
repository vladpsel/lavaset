<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'wabiwasabi@gmail.com',
            'phone' => '+380 12 345 67 89',
            'password' => Hash::make('password'),
        ]);

        DB::table('user_roles')->insert([
            'user_id' => 1,
            'role' => 'admin',
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'User',
            'email' => 'user@gmail.com',
            'phone' => '+380 12 345 67 80',
            'password' => Hash::make('password'),
        ]);

        DB::table('user_roles')->insert([
            'user_id' => 2,
            'role' => 'user',
        ]);
    }
}
