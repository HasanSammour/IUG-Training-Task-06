<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Tech Suppliers Inc.',
                'email' => 'orders@techsuppliers.com'
            ],
            [
                'name' => 'Global Fashion Distributors',
                'email' => 'contact@globalfashion.com'
            ],
            [
                'name' => 'Home Essentials Ltd.',
                'email' => 'sales@homeessentials.com'
            ],
            [
                'name' => 'Book World Publishers',
                'email' => 'orders@bookworld.com'
            ],
            [
                'name' => 'Sports Gear International',
                'email' => 'info@sportsgear.com'
            ],
            [
                'name' => 'Health & Beauty Co.',
                'email' => 'supply@healthbeauty.com'
            ],
            [
                'name' => 'Toy Masters Ltd.',
                'email' => 'orders@toymasters.com'
            ],
            [
                'name' => 'Auto Parts Express',
                'email' => 'contact@autopartsexpress.com'
            ]
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        $this->command->info('✅ ' . count($suppliers) . ' suppliers created successfully.');
    }
}