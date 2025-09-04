<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'ronaldjjuuko7@gmail.com'],
            [
                'name' => 'JRonnie',
                'email' => 'ronaldjjuuko7@gmail.com',
                'phone' => '0703283529',
                'country' => 'UG',
                'password' => Hash::make('88928892'), 
                'email_verified_at' => now(),
            ]
        );
    }
}
