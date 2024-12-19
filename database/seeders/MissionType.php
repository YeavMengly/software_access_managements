<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MissionType extends Seeder
{
    public function run(): void
    {
        DB::table('mission_types')->truncate(); // Clear existing data

         /*
         |-------------------------------------------------------------------------------
         | Add 7 Code
         |-------------------------------------------------------------------------------
         */
        DB::table('mission_types')->insert([
            [
                 'name' => 'រជ្ចទេយ្យ',
                 'created_at' => now(),
                 'updated_at' => now(),
            ],
            [
                'name' => 'លទ្ធកម្ម',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ទូទាត់ត្រង់',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
