<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing pivot data
        DB::table('product_supplier')->truncate();

        $products = Product::all();
        $suppliers = Supplier::all();

        if ($products->isEmpty() || $suppliers->isEmpty()) {
            $this->command->warn('No products or suppliers found! Please run ProductSeeder and SupplierSeeder first.');
            return;
        }

        $this->command->info('Attaching suppliers to products...');

        foreach ($products as $product) {
            // Attach 1-3 random suppliers to each product
            $randomSuppliers = $suppliers->random(rand(1, 3));
            
            foreach ($randomSuppliers as $supplier) {
                // Generate realistic pivot data based on product price
                $costPrice = $product->price * (rand(60, 90) / 100); // 60-90% of retail price
                $leadTimeDays = rand(1, 14); // 1-14 days lead time
                
                $product->suppliers()->attach($supplier->id, [
                    'cost_price' => $costPrice,
                    'lead_time_days' => $leadTimeDays
                ]);
            }

            $this->command->info("Product: {$product->name} → " . count($randomSuppliers) . " suppliers attached");
        }

        $totalRelations = DB::table('product_supplier')->count();
        $this->command->info("✅ Total product-supplier relationships: {$totalRelations}");
    }
}