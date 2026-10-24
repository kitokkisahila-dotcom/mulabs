<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Admin extends Seeder
{
    
    public function run(): void
    {
        DB::table('users')->insert([

            'first_name' => 'Michael',
            'second_name' => 'Obedi',
            'last_name' => 'Kitoki',
            'registration_no' => 'admin123',
            'email' => 'kitoki@gmail.com',
            'phone' => '0764567890',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'sex' => 'Male',
            'role' => 'admin',
            'program_id' => null,
            'department_id' => null,
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}