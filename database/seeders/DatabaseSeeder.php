<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ! Updated from Task 05: Seed the DB tables
        // Run categories first
        $this->call(CategorySeeder::class);
        // ! From Task 06: Seed suppliers
        $this->call(SupplierSeeder::class);
        // Then run products (which need categories)
        $this->call(ProductSeeder::class);
        // ! From Task 06: Seed product-supplier pivot table
        $this->call(ProductSupplierSeeder::class);
    }
}