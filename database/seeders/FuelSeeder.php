<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FuelSeeder extends Seeder
{
    /**
     * Seed the fuel_tags table with initial fuel types.
     */
    public function run(): void
    {
        /*
        |-------------------------------------------------------------------------------
        |  Clear existing data
        |-------------------------------------------------------------------------------
        */
        DB::table('fuel_tags')->truncate();

        /*
        |-------------------------------------------------------------------------------
        | Insert data into fuel_tags table
        |-------------------------------------------------------------------------------
        */
        DB::table('fuel_tags')->insert([
            ['fuel_tag' => 'ប្រេងសាំង', 'created_at' => now(), 'updated_at' => now()],      // Gasoline
            ['fuel_tag' => 'ប្រេងម៉ាស៊ូត', 'created_at' => now(), 'updated_at' => now()],    // Diesel
            ['fuel_tag' => 'ប្រេងម៉ាស៊ីន', 'created_at' => now(), 'updated_at' => now()]     // Engine oil
        ]);
    }
}
