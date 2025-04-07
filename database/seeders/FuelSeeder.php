<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FuelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('fuel_tags')->truncate();
        DB::table('fuel_tags')->insert([
            ['fuel_tag' => 'ប្រេងសាំង', 'created_at' => now(), 'updated_at' => now()],
            ['fuel_tag' => 'ប្រេងម៉ាស៊ូត', 'created_at' => now(), 'updated_at' => now()],
            ['fuel_tag' => 'ប្រេងម៉ាស៊ីន', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
