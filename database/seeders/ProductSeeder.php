<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 random products
        Product::factory()->count(10)->create();

        // Create 5 expensive electronic products
        Product::factory()->count(5)->electronic()->expensive()->create();
        
        // Create 3 cheap books
        Product::factory()->count(3)->book()->cheap()->create();
        
        // Create specific category products
        Product::factory()->count(4)->category('tech')->create();
        Product::factory()->count(2)->category('home')->create();
    }
}