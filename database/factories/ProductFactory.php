<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    // ! From Task 05: New Product Factory that holds all Categories
    // * [Category => Products] associative-array
    private $productCategories = [
        'Electronics' => ['Laptop', 'Smartphone', 'Tablet', 'Monitor', 'Keyboard', 'Mouse', 'Headphones', 'Speaker', 'Smart Watch', 'Camera', 'Drone', 'Router'],
        'Fashion' => ['T-Shirt', 'Jeans', 'Jacket', 'Dress', 'Shoes', 'Hat', 'Sunglasses', 'Watch', 'Belt', 'Handbag', 'Scarf', 'Gloves'],
        'Home & Garden' => ['Chair', 'Table', 'Lamp', 'Sofa', 'Bed', 'Cabinet', 'Plant', 'Grill', 'Tool Set', 'Blender', 'Microwave', 'Vacuum'],
        'Books' => ['Novel', 'Biography', 'Cookbook', 'Textbook', 'Mystery', 'Fantasy', 'Science Fiction', 'History', 'Poetry', 'Children Book'],
        'Sports' => ['Football', 'Basketball', 'Tennis Racket', 'Yoga Mat', 'Dumbbells', 'Bicycle', 'Helmet', 'Running Shoes', 'Swim Goggles', 'Fitness Tracker'],
        'Health & Beauty' => ['Shampoo', 'Perfume', 'Skin Cream', 'Toothpaste', 'Hair Dryer', 'Makeup Kit', 'Vitamins', 'Face Mask', 'Body Lotion', 'Razor'],
        'Toys' => ['Lego Set', 'Doll', 'Action Figure', 'Board Game', 'Puzzle', 'Remote Car', 'Building Blocks', 'Educational Toy', 'Stuffed Animal', 'Play Dough'],
        'Automotive' => ['Car Wax', 'Tire', 'Battery', 'Oil Filter', 'Car Cover', 'GPS', 'Dash Cam', 'Seat Cover', 'Jump Starter', 'Air Freshener']
    ];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // ! Steps to Generate Random Product
        // * 1- Get random category
        $categoryName = $this->faker->randomElement(array_keys($this->productCategories));
        
        // Get category from database
        $category = Category::where('name', $categoryName)->first();
        
        return [
            'name' => $this->faker->unique()->words(rand(2, 4), true), // "Wireless Mouse Pro"
            'price' => $this->faker->randomFloat(2, 5, 2000),
            'description' => $this->faker->paragraph(rand(1, 3)),
            'category_id' => $category ? $category->id : null
        ];
    }

    /**
     * Indicate that the product is expensive.
     */
    public function expensive(): static
    {
        return $this->state(fn (array $attributes) => [
            'price' => $this->faker->randomFloat(2, 500, 2000),
        ]);
    }

    /**
     * Indicate that the product is cheap.
     */
    public function cheap(): static
    {
        return $this->state(fn (array $attributes) => [
            'price' => $this->faker->randomFloat(2, 1, 100),
        ]);
    }

    /**
     * Indicate that the product is electronic.
     */
    public function electronic(): static
    {
        $electronicProducts = [
            'Laptop', 'Smartphone', 'Tablet', 'Monitor', 'Keyboard',
            'Mouse', 'Headphones', 'Speaker', 'Smart Watch', 'Camera'
        ];

        return $this->state(fn (array $attributes) => [
            'name' => $this->faker->randomElement($electronicProducts) . ' ' . $this->faker->word(),
            'description' => $this->faker->sentence(10) . ' Electronic device with warranty.',
        ]);
    }

    /**
     * Indicate that the product is a book.
     */
    public function book(): static
    {
        $bookTitles = [
            'The Great Gatsby', '1984', 'To Kill a Mockingbird',
            'Pride and Prejudice', 'The Catcher in the Rye',
            'The Hobbit', 'Harry Potter', 'The Alchemist'
        ];

        return $this->state(fn (array $attributes) => [
            'name' => $this->faker->randomElement($bookTitles),
            'price' => $this->faker->randomFloat(2, 5, 50),
            'description' => $this->faker->paragraph(2) . ' By ' . $this->faker->name() . '.',
        ]);
    }

    /**
     * Indicate specific product categories.
     */
    public function category(string $category): static
    {
        $categories = [
            'tech' => ['Laptop', 'Phone', 'Tablet'],
            'home' => ['Chair', 'Table', 'Lamp'],
            'clothing' => ['Shirt', 'Pants', 'Shoes'],
            'food' => ['Chocolate', 'Coffee', 'Snacks']
        ];

        return $this->state(fn (array $attributes) => [
            'name' => $this->faker->randomElement($categories[$category] ?? ['Product']) . ' ' . $this->faker->word(),
            'description' => ucfirst($category) . ' product. ' . $this->faker->sentence(5),
        ]);
    }

    // ! New function That generates Product for a specific category
    /**
     * Create product for specific category
     */
    public function forCategory(string $categoryName): static
    {
        $category = Category::where('name', $categoryName)->first();
        
        $categoryProducts = [
            'Electronics' => [
                'names' => ['Laptop', 'Smartphone', 'Tablet', 'Monitor', 'Keyboard', 'Mouse'],
                'descriptions' => ['High-tech device', 'Latest technology', 'Advanced features', 'Wireless connection']
            ],
            'Fashion' => [
                'names' => ['T-Shirt', 'Jeans', 'Jacket', 'Dress', 'Shoes'],
                'descriptions' => ['Premium quality', 'Comfortable wear', 'Latest fashion', 'Trendy design']
            ],
            'Home & Garden' => [
                'names' => ['Chair', 'Table', 'Lamp', 'Sofa', 'Plant'],
                'descriptions' => ['For your home', 'Durable material', 'Easy to assemble', 'Modern design']
            ],
            'Books' => [
                'names' => ['Novel', 'Biography', 'Cookbook', 'Textbook'],
                'descriptions' => ['Best selling', 'Educational', 'Inspirational', 'Classic literature']
            ],
            'Sports' => [
                'names' => ['Football', 'Basketball', 'Tennis Racket', 'Yoga Mat'],
                'descriptions' => ['Professional grade', 'For training', 'Durable', 'Lightweight']
            ],
            'Health & Beauty' => [
                'names' => ['Shampoo', 'Perfume', 'Skin Cream', 'Vitamins'],
                'descriptions' => ['Natural ingredients', 'Healthy choice', 'Beauty care', 'Wellness product']
            ],
            'Toys' => [
                'names' => ['Lego Set', 'Doll', 'Board Game', 'Puzzle'],
                'descriptions' => ['Educational toy', 'Fun for kids', 'Safe material', 'Creative play']
            ],
            'Automotive' => [
                'names' => ['Car Wax', 'Tire', 'Battery', 'GPS'],
                'descriptions' => ['Car accessory', 'Vehicle maintenance', 'Safety product', 'Car care']
            ]
        ];

        if ($category && isset($categoryProducts[$categoryName])) {
            $productData = $categoryProducts[$categoryName];
            
            return $this->state(fn (array $attributes) => [
                'name' => $this->faker->randomElement($productData['names']) . ' ' . 
                         $this->faker->word() . ' ' . 
                         $this->faker->randomElement(['Pro', 'Plus', 'Deluxe', 'Edition', '2024']),
                'description' => $this->faker->randomElement($productData['descriptions']) . '. ' . 
                               $this->faker->sentence(8),
                'price' => $this->getCategoryPriceRange($categoryName),
                'category_id' => $category->id
            ]);
        }

        return $this;
    }

    /**
     * Get price range based on category
     */
    private function getCategoryPriceRange(string $categoryName): float
    {
        $priceRanges = [
            'Electronics' => [100, 3000],
            'Fashion' => [20, 500],
            'Home & Garden' => [30, 1500],
            'Books' => [5, 100],
            'Sports' => [10, 800],
            'Health & Beauty' => [5, 300],
            'Toys' => [10, 400],
            'Automotive' => [15, 1000]
        ];

        $range = $priceRanges[$categoryName] ?? [10, 500];
        return $this->faker->randomFloat(2, $range[0], $range[1]);
    }

    /**
     * Create products for all categories
     */
    public function forAllCategories(): static
    {
        $categories = Category::all();
        if ($categories->count() > 0) {
            $randomCategory = $categories->random();
            return $this->state(fn (array $attributes) => [
                'category_id' => $randomCategory->id
            ]);
        }
        
        return $this;
    }
}