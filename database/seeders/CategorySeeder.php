<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ! From Task 05 _ Seed DB with Categories
        $categories = [
            ['name' => 'Electronics'],
            ['name' => 'Fashion'],
            ['name' => 'Home & Garden'],
            ['name' => 'Books'],
            ['name' => 'Sports'],
            ['name' => 'Health & Beauty'],
            ['name' => 'Toys'],
            ['name' => 'Automotive'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}