<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Business;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for your application (e.g., managing posts, users, etc.)
        // This is a basic example, you'd define what makes sense for your app
        Permission::create(['name' => 'add-users']);
        Permission::create(['name' => 'manage-settings']);


        // You can create more permissions based on your application's needs

        // Create roles and assign permissions
        $superadminRole = Role::create(['name' => 'superadmin']);
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Assign all existing permissions to the superadmin role
        $superadminRole->givePermissionTo(Permission::all());

        $this->command->info('Roles and permissions seeded successfully!');


        //  Create or get the business
        $business = Business::updateOrCreate(
            ['email' => 'info@thetechtower.com'],
            [
                'name' => "TechTower Inc",
                'currency' => 'USD',
                'email' => 'info@thetechtower.com',
                'country' => 'UG',
                'phone' => '+256703283529',
            ]
        );



        // Create or update the user tied to this business
        $user = User::updateOrCreate(
            ['email' => 'ronaldjjuuko7@gmail.com'],
            [
                'name' => 'JRonnie',
                'phone' => '+256703283529',
                'password' => Hash::make('88928892'),
                'status' => 'active',
                'email_verified_at' => now(),
                'business_id' => $business->id,
            ]
        );

        $user->assignRole('superadmin');



        // Create 1-month trial subscription for the business
        $business->subscriptions()->updateOrCreate(
            ['business_id' => $business->id],
            [
                'subscription_plan_id' => 1,
                'billing_cycle' => 'monthly',
                'trial_ends_at' => now()->addYear(),
                'starts_at' => now(),
                'ends_at' => now()->addYear(),
                'payment_method' => null,
                'is_active' => true,
                'auto_renew' => false,
            ]
        );

        $this->command->info('Business and user,  subscription seeded successfully!');




    }
}