<?php

namespace Database\Seeders;

use App\Models\bulk;
use App\Models\inventory;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory(10)->create()->each(function(Product $product){
            $bulks = Bulk::create([
                'product_id' => $product->id,
                'units_per_bulk' => rand(10, 20),
                'quantity_bulk' => rand(1, 2),
                'price_per_bulk' => rand(10,20),
            ]);

            Inventory::create([
                'product_id' => $product->id,
                'stock' => $bulks->quantity_bulk * $bulks->units_per_bulk,
                'cost_price' => $bulks->price_per_bulk,
                'minimun_stock' => 3,
                'last_updated' => null, // Assuming last_updated is nullable
            ]);
        });
   }
}
