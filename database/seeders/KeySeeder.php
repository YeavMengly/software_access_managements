<?php

namespace Database\Seeders;

use App\Models\Code\Key;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |-------------------------------------------------------------------------------
        |  Clear existing data
        |-------------------------------------------------------------------------------
        */
        DB::table('keys')->truncate(); // Clear existing data

        /*
        |-------------------------------------------------------------------------------
        | Insert data into keys table
        |-------------------------------------------------------------------------------
        | Add 7 COde
        |-------------------------------------------------------------------------------
        */
        DB::table('keys')->insert([
            [
                'code' => '21',
                'name' => 'អចលកម្មរូបី',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => '60',
                'name' => 'ការទិញ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => '61',
                'name' => 'សេវាកម្ម',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => '62',
                'name' => 'អត្ថប្រយោជន៍សង្គម',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => '63',
                'name' => 'ពន្ធ និងអាករ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => '64',
                'name' => 'បន្ទុកបុគ្គលិក',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => '65',
                'name' => 'ឧបត្ថម្ភធន',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
