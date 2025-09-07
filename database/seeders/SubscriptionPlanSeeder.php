<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $plans = [
            [
                'name' => 'Starter',
                'description' => 'Basic plan for small businesses',
                'monthly_cost' => 20.00,
                'annual_cost' => 180.00,
                'max_users' => 1,
                'max_products' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Pro',
                'description' => 'Professional plan for growing businesses',
                'monthly_cost' => 50.00,
                'annual_cost' => 480.00,
                'max_users' => 5,
                'max_products' => 200,
                'is_active' => true,
            ],
            [
                'name' => 'Enterprise',
                'description' => 'Advanced plan for large businesses',
                'monthly_cost' => 100.00,
                'annual_cost' => 980.00,
                'max_users' => 20,
                'max_products' => 10000,
                'is_active' => true,
            ],
        ];

        foreach ($plans as $planData) {
            SubscriptionPlan::updateOrCreate(
                ['name' => $planData['name']], 
                $planData
            );
        }

        $this->command->info('3 Subscription Plans seeded successfully!');
    
    }
}
