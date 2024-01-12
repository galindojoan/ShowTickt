<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' =>'promotor1',
            'email' => 'promotor1@test.com',
            'password' => Hash::make('p12345678'),
        ]);
        DB::table('users')->insert([
            'name' =>'promotor2',
            'email' => 'promotor2@test.com',
            'password' => Hash::make('p2345678'),
        ]);

    }
}
