<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MissionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        DB::table('mission_types')->truncate();

        // Insert new data
        DB::table('mission_types')->insert([
            [
                'mission_type' => 'រជ្ចទេយ្យ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mission_type' => 'លទ្ធកម្ម',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mission_type' => 'បើកផ្ដល់មុន',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
