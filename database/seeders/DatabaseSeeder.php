<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'first_name' => 'ngwala',
            'second_name' => 'joseph',
            'last_name' => 'john',
            'registration_no' => 'admin1234',
            'phone' => '0764567845',
            'email' => 'ngwa@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'sex' => 'Male',
            'role' => 'admin',
            'program_id' => null,
            'department_id' => null,
            'image' => 'pasport.png',   
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}