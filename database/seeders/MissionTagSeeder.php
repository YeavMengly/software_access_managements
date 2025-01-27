<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MissionTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mission_tags')->truncate();
        DB::table('mission_tags')->insert([
            ['m_tag' => 'ថ្នាក់ជាតិ', 'created_at' => now(), 'updated_at' => now()],
            ['m_tag' => 'មូលដ្ឋាន', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
