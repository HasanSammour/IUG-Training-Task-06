<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
            'name' => $this->faker->words(rand(1, 3), true), // "Wireless Mouse", "Laptop Pro", etc
            'price' => $this->faker->randomFloat(2, 10, 1000), // Price between 10-1000
            'description' => $this->faker->paragraph(rand(1, 3)), // 1-3 paragraphs
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
}