<?php

namespace Tests\Feature\Http\Api;

use App\Http\Controllers\Api\Buy\BuyController;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompraTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        //preparacion del test
        $dataRequest = [
            'buy_invoice' => [
                'supplier_id' => 1556491002,
                'date_buy' => '2025-08-03',
                'status' => 'paid',
                'total_amount' => 'se calcula'
            ],
            'products' => [
                [
                    'id' => null,
                    'name' => 'Cable HDMI',
                    'description' => 'descripcion',
                    'sale_price' => 'Se calcula',
                    'date_of_entry' => '2025-08-03',
                    'due_date' => '2026-08-03',
                    'category_id' => 1,
                    'imagen' => null
                ],
                [
                    'id' => null,
                    'name' => 'Cable HDMI 2',
                    'description' => 'descripcion 2',
                    'date_of_entry' => '2025-08-03',
                    'due_date' => '2026-08-03',
                    'category_id' => 1,
                    'imagen' => null
                ]
            ],
            'purchase_details' => [
                [
                    'quantity_buy_product' => 5,
                    'price_buy' => 10,
                    'bulk' => null
                ],
                [
                    'quantity_buy_product' => 10,
                    'price_buy' => 12,
                    'bulk' => null
                ]
            ],
            'option' => [
                'porcentaje' => 0.30
            ]
        ];

        //Ejecucion del test

        $response = $this->postJson(action([BuyController::class, 'store']), $dataRequest);
        
        //asserts        
        $response->assertStatus(201); 
        $this->assertArrayHasKey('message', $response->json());
        $this->assertArrayHasKey('buy_invoice_id', $response->json());
        $this->assertArrayHasKey('total_amount', $response->json());
        $this->assertArrayHasKey('product_ids', $response->json());
        $this->assertArrayHasKey('items_count', $response->json());
    }
}
