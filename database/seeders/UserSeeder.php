<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /*
        |-------------------------------------------------------------------------------
        | Create data into table
        |-------------------------------------------------------------------------------
        */
        User::create([
            'name' => 'admin',
            'phone_number' => '077335157',
            'password' => Hash::make('1234admin'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'User',
            'phone_number' => '123456789',
            'password' => Hash::make('1234user'),
            'role' => 'user',
        ]);
    }
}
