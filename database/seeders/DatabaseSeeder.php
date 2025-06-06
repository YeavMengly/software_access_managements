<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Call Necessary Seeders
        |--------------------------------------------------------------------------
        */
        $this->call([
            KeySeeder::class,
            AccountKeySeeder::class,
            SubAccountKeySeeder::class,
            UserSeeder::class,
            MissionTypeSeeder::class,
            MissionTagSeeder::class,
            ProvinceCitySeeder::class,
            FuelSeeder::class,
            UnitTypeSeeder::class
        ]);
    }
}
