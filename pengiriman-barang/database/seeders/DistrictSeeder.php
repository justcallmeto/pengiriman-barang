<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('districts')->insert(
            ['district_name'=> 'Klakah'],     
        );
        DB::table('districts')->insert(
            ['district_name'=> 'Pasirian'],    
        );
        DB::table('districts')->insert(
            ['district_name'=> 'Candipuro'],  
        );
        DB::table('districts')->insert(
            ['district_name'=> 'Kunir'],  
        );
        DB::table('districts')->insert(
            ['district_name'=> 'Tempeh'],  
        );
        
    }
}
