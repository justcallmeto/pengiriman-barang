<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('delivery_statuses')->insert(
            ['delivery_status'=> 'Sedang Dipickup'],     
        );
        DB::table('delivery_statuses')->insert(
            ['delivery_status'=> 'Sedang Dikirim'],    
        );
        DB::table('delivery_statuses')->insert(
            ['delivery_status'=> 'Telah Tiba'],  
        );
        
    }
}
