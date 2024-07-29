<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ad_positions')->insert([
            'position' => 'Header',
        ]);

        DB::table('ad_positions')->insert([
            'position' => 'Right Bar',
        ]);

        DB::table('ad_positions')->insert([
            'position' => 'Left Bar',
        ]);

        DB::table('ad_positions')->insert([
            'position' => 'Middle Home 1',
        ]);

        DB::table('ad_positions')->insert([
            'position' => 'Middle Home 2',
        ]);

        DB::table('ad_positions')->insert([
            'position' => 'Footer',
        ]);
        
        DB::table('ad_positions')->insert([
            'position' => 'Middle Category',
        ]);


    }
}
