<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class DeliveryEventPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'view_delivery::event',
            'view_any_delivery::event',
            'create_delivery::event',
            'update_delivery::event',
            'delete_delivery::event',
            'restore_delivery::event',
            'force_delete_delivery::event',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
