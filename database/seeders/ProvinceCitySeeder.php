<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceCitySeeder extends Seeder
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
        DB::table('province_cities')->truncate();

        /*
        |-------------------------------------------------------------------------------
        | Insert data into province_cities table
        |-------------------------------------------------------------------------------
        */
        DB::table('province_cities')->insert([
            ['province_city' => 'ភ្នំពេញ', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'កណ្ដាល', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'កំពង់ចាម', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'កែប', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'បន្ទាយមានជ័យ', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'កំពង់ឆ្នាំង', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'កំពង់ស្ពឺ', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'កំពង់ធំ', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'កំពត', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'កោះកុង', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'ក្រចេះ', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'មណ្ឌលគីរី', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'ឧត្តរមានជ័យ', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'ប៉ៃលិន', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'ព្រះសីហនុ', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'ព្រះវិហារ', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'ពោធិ៍សាត់', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'រតនគីរី', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'សៀមរាប', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'ស្ទឹងត្រែង', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'ស្វាយរៀង', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'តាកែវ', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'ត្បូងឃ្មុំ', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'ព្រៃវែង', 'created_at' => now(), 'updated_at' => now()],
            ['province_city' => 'បាត់ដំបង', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
