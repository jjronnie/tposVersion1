<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Business;


class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


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
                'email_verified_at' => now(),
                'business_id' => $business->id,
            ]
        );



        // Create 1-month trial subscription for the business
        $business->subscriptions()->updateOrCreate(
            ['business_id' => $business->id],
            [
                'subscription_plan_id' => 1,
                'billing_cycle' => 'monthly',
                'trial_ends_at' => now()->addMonth(),
                'starts_at' => now(),
                'ends_at' => now()->addMonth(),
                'payment_method' => null,
                'is_active' => true,
                'auto_renew' => false,
            ]
        );

        $this->command->info('Business and user,  subscription seeded successfully!');

    }
}
