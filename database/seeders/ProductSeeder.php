<?php

namespace Database\Seeders;

use App\Models\bulk;
use App\Models\inventory;
use App\Models\Product;
use App\Models\Transaction_history;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Manejo de factory para crear productos, bultos e inventario
        Product::factory(10)->create()->each(function(Product $product){
            //Crear bultos para cada producto
            $bulks = Bulk::create([
                'product_id' => $product->id,
                'units_per_bulk' => rand(10, 20),
                'quantity_bulk' => rand(1, 2),
                'price_per_bulk' => rand(10,20),
            ]);

            //Registro de inventario para cada producto
            Inventory::create([
                'product_id' => $product->id,
                'stock' => $bulks->quantity_bulk * $bulks->units_per_bulk,
                'minimun_stock' => 3,
                'last_updated' => now(),
            ]);

            // Crear historial de transacciones para cada producto
            Transaction_history::create([
                'product_id'       => $product->id,
                'user_id'          => 1, // ID de usuario ficticio
                'transaction_type' => 'buy',
                'quantity'         => $bulks->quantity_bulk * $bulks->units_per_bulk,
                'description'      => 'Compra de productos iniciales',
            ]);
        });
   }
}
