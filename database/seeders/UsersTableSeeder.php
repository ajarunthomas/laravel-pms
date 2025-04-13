<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('1a2b3c4d'),
            'access_level' => 'admin'
        ]);

        DB::table('users')->insert([
            'name' => 'User',
            'username' => 'user',
            'password' => bcrypt('12345678'),
            'access_level' => 'user'
        ]);
    }
}
