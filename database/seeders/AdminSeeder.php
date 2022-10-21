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
            'password' => Hash::make('password'),
        ]);

        DB::table('user_roles')->insert([
            'user_id' => 1,
            'role' => 'admin',
        ]);
    }
}
