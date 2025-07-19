<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'manage_menu_items',
            'manage_orders',
            'manage_expenses',
            'manage_staff',
            'manage_rentals',
            'view_analytics',
            'manage_users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $tenantRole = Role::firstOrCreate(['name' => 'tenant']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // Assign permissions to roles
        $adminRole->givePermissionTo($permissions); // Admin gets all permissions

        $tenantRole->givePermissionTo([
            'manage_menu_items',
            'manage_orders',
            'manage_expenses',
            'manage_staff',
            'view_analytics',
        ]);

        $customerRole->givePermissionTo([
            // Customers don't need special permissions for basic functionality
        ]);
    }
}