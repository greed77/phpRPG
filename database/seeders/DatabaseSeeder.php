<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'manage-roles',
            'manage-users', 
            'view-admin-panel',
            'manage-settings',
            'manage-characters',
            'view-reports'
        ];
        
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $staffRole = Role::create(['name' => 'staff']);
        
        // Assign permissions to roles
        $adminRole->givePermissionTo($permissions); // Admin gets all permissions
        $staffRole->givePermissionTo(['view-admin-panel', 'view-reports']); // Staff gets limited permissions

        // Create admin user
        $adminUser = User::factory()
            ->has(Character::factory()->count(3))
            ->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
            ]);
        $adminUser->assignRole('admin');

        // Create test user (no role = regular user)
        $testUser = User::factory()
            ->has(Character::factory()->count(3))
            ->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
    }
}
