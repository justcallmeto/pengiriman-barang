<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $user = User::factory()->create([
            'name' => 'Tunas Jaya Dev',
            'email' => 'tunasjaya@dev.com',
            'password'=>bcrypt('password'),
        ]);
        $user->assignRole('super_admin');
    }
}
