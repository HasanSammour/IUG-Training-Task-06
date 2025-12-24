<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class ProductSeeder extends Seeder
{
    protected $faker;
    
    public function __construct()
    {
        $this->faker = FakerFactory::create();
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
 // Get all categories
        $categories = Category::all();
        
        if ($categories->isEmpty()) {
            $this->command->warn('No categories found! Please run CategorySeeder first.');
            return;
        }
        
        // Fixed products for specific categories
        $fixedProducts = [
            [
                'name' => 'MacBook Pro 16"',
                'price' => 2399.99,
                'description' => 'Apple MacBook Pro with M3 chip, 16GB RAM, 512GB SSD',
                'category_id' => $categories->where('name', 'Electronics')->first()->id
            ],
            [
                'name' => 'Wireless Gaming Mouse',
                'price' => 89.99,
                'description' => 'RGB wireless mouse with 16000 DPI, rechargeable battery',
                'category_id' => $categories->where('name', 'Electronics')->first()->id
            ],
            [
                'name' => 'Leather Jacket',
                'price' => 199.99,
                'description' => 'Genuine leather jacket with zip pockets',
                'category_id' => $categories->where('name', 'Fashion')->first()->id
            ],
            [
                'name' => 'Running Shoes',
                'price' => 129.99,
                'description' => 'Lightweight running shoes with cushion technology',
                'category_id' => $categories->where('name', 'Fashion')->first()->id
            ],
            [
                'name' => 'Modern Sofa',
                'price' => 899.99,
                'description' => '3-seater modern sofa with wooden legs',
                'category_id' => $categories->where('name', 'Home & Garden')->first()->id
            ],
            [
                'name' => 'Indoor Plant Set',
                'price' => 49.99,
                'description' => 'Set of 5 indoor plants with pots',
                'category_id' => $categories->where('name', 'Home & Garden')->first()->id
            ],
            [
                'name' => 'Programming Book',
                'price' => 39.99,
                'description' => 'Complete guide to web development with Laravel',
                'category_id' => $categories->where('name', 'Books')->first()->id
            ],
            [
                'name' => 'Mystery Novel',
                'price' => 14.99,
                'description' => 'Best selling mystery thriller',
                'category_id' => $categories->where('name', 'Books')->first()->id
            ],
            [
                'name' => 'Professional Football',
                'price' => 34.99,
                'description' => 'Official size and weight football',
                'category_id' => $categories->where('name', 'Sports')->first()->id
            ],
            [
                'name' => 'Yoga Mat Premium',
                'price' => 29.99,
                'description' => 'Non-slip yoga mat with carrying strap',
                'category_id' => $categories->where('name', 'Sports')->first()->id
            ],
            [
                'name' => 'Vitamin C Serum',
                'price' => 24.99,
                'description' => 'Anti-aging serum with vitamin C',
                'category_id' => $categories->where('name', 'Health & Beauty')->first()->id
            ],
            [
                'name' => 'Electric Toothbrush',
                'price' => 59.99,
                'description' => 'Rechargeable electric toothbrush with 3 modes',
                'category_id' => $categories->where('name', 'Health & Beauty')->first()->id
            ],
            [
                'name' => 'LEGO Technic Set',
                'price' => 149.99,
                'description' => 'Advanced LEGO set with 2000+ pieces',
                'category_id' => $categories->where('name', 'Toys')->first()->id
            ],
            [
                'name' => 'Remote Control Car',
                'price' => 79.99,
                'description' => '1:10 scale RC car with 2.4GHz remote',
                'category_id' => $categories->where('name', 'Toys')->first()->id
            ],
            [
                'name' => 'Car GPS Navigation',
                'price' => 129.99,
                'description' => '7-inch touchscreen GPS with lifetime updates',
                'category_id' => $categories->where('name', 'Automotive')->first()->id
            ],
            [
                'name' => 'Car Wash Kit',
                'price' => 39.99,
                'description' => 'Complete car washing kit with microfiber towels',
                'category_id' => $categories->where('name', 'Automotive')->first()->id
            ],
        ];

        $this->command->info('Creating fixed products for all categories...');
        foreach ($fixedProducts as $product) {
            Product::create($product);
        }

        // Create products using factory for EACH category
        $this->command->info('Creating factory products for each category...');
        
        foreach ($categories as $category) {
            $productCount = rand(3, 8); // 3-8 products per category
            
            $this->command->info("Creating {$productCount} products for category: {$category->name}");
            
            // Create products for this specific category
            Product::factory()->count($productCount)->create([
                'category_id' => $category->id
            ]);
            
            // Create some specialized products for this category
            switch ($category->name) {
                case 'Electronics':
                    Product::factory()->electronic()->create([
                        'category_id' => $category->id,
                        'price' => rand(299, 1999)
                    ]);
                    break;
                case 'Books':
                    Product::factory()->book()->create([
                        'category_id' => $category->id
                    ]);
                    break;
                case 'Fashion':
                    Product::factory()->create([
                        'name' => 'Designer ' . $this->faker->word() . ' Collection',
                        'price' => rand(99, 499),
                        'category_id' => $category->id,
                        'description' => 'Luxury fashion item from premium collection'
                    ]);
                    break;
            }
        }

        // Create some random products with random categories
        $this->command->info('Creating additional random products...');
        Product::factory()->count(15)->forAllCategories()->create();

        $totalProducts = Product::count();
        $this->command->info("✅ Total products created: {$totalProducts}");
        
        // Show statistics
        $this->command->info("\n📊 Product Distribution by Category:");
        foreach ($categories as $category) {
            $count = Product::where('category_id', $category->id)->count();
            $this->command->info("  {$category->name}: {$count} products");
        }
    }
}