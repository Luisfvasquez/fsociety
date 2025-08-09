<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleRequest;
use App\Models\Buy_invoice;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Purchase_invoice_detail;
use App\Models\Transaction_history;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function store(SaleRequest $request)/*  : JsonResponse */
    {
        $data       = $request->validated();
        $products   = $data['products'];
        $details    = $data['purchase_details'];
        $porcentaje = (float) $data['option']['porcentaje'];

        // Usar array_reduce para sumar el total de la compra
        // $carry representa el acumulador, detail es el elemento actual
        $total = array_reduce($details, function ($carry, $detail) {
            return $carry + ((float) $detail['price_buy'] * (float) $detail['quantity_buy_product']);
        }, 0.0); //0.0 representa el valor inicial del acumulador
        

        
        // Fecha y hora actual
        $now    = now(); 
        
        // ID del usuario autenticado, o 1 si no hay usuario autenticado para pruebas
        $userId = auth()->id() ?? 1; 

        return DB::transaction(function () use ($data, $products, $details, $porcentaje, $total, $now, $userId) {
            // Crear factura de compra
            $buy = Buy_invoice::create([
                'supplier_id'  => $data['buy_invoice']['supplier_id'],
                'date_buy'     => $data['buy_invoice']['date_buy'],
                'status'       => $data['buy_invoice']['status'],
                'total_amount' => round($total, 2),
            ]);

            $detailRows      = [];
            $historyRows     = [];
            $createdProducts = [];

            // Un solo bucle para producto, detalle, inventario e historial
            foreach ($products as $i => $p) {
                $d          = $details[$i]; //alamacenamos el detalle de compra correspondiente del producto
                $cost       = (float) $d['price_buy'];
                $qty        = (float) $d['quantity_buy_product'];
                $sale_price = round($cost * (1 + $porcentaje), 2);

                // Normalizar imagen "null" (string) -> null
                $imagen = isset($p['imagen']) && $p['imagen'] !== 'null' ? $p['imagen'] : null;

                // Crear o actualizar producto
                if (!empty($p['id'])) {
                    $product = Product::findOrFail($p['id']);
                    $product->update([
                        'sale_price'    => $sale_price,
                        'date_of_entry' => $p['date_of_entry'] ?? $product->date_of_entry,
                        'due_date'      => $p['due_date'] ?? $product->due_date,
                        'category_id'   => $p['category_id'] ?? $product->category_id,
                        'description'   => $p['description'] ?? $product->description,
                        'imagen'        => $imagen ?? $product->imagen,
                    ]);
                } else {
                    $product = Product::create([
                        'name'          => $p['name'],
                        'description'   => $p['description'] ?? null,
                        'sale_price'    => $sale_price,
                        'date_of_entry' => $p['date_of_entry'],
                        'due_date'      => $p['due_date'] ?? null,
                        'category_id'   => $p['category_id'],
                        'imagen'        => $imagen,
                    ]);
                }

                $createdProducts[] = $product->id;

                // Detalle (para inserción en lote)
                $detailRows[] = [
                    'buy_invoice_id'       => $buy->id,
                    'product_id'           => $product->id,
                    'quantity_buy_product' => $qty,
                    'price_buy_product'    => $cost,
                    'bulk_id'              => $d['bulk_id'] ?? null,
                ];
                // Inventario: asegurar registro y sumar stock
                $inventory = Inventory::firstOrCreate(
                    ['product_id' => $product->id],
                    [
                        'stock'         => 0,
                        'minimun_stock' => 3,
                        'last_updated'  => $now,
                    ]
                );

                // Incrementar stock actual sumando la cantidad comprada
                $inventory->increment('stock', $qty);
                // Actualizar la fecha de última actualización
                $inventory->update(['last_updated' => $now]);

                // Historial (para inserción en lote)
                $historyRows[] = [
                    'product_id'       => $product->id,
                    'user_id'          => $userId,
                    'transaction_type' => 'buy',
                    'quantity'         => $qty,
                    'description'      => 'Compra de producto',
                ];
            }

            // Inserts en lote
            //optimiza el rendimiento al reducir el número de consultas a la base de datos
            if (!empty($detailRows)) {
                Purchase_invoice_detail::insert($detailRows);
            }
            if (!empty($historyRows)) {
                Transaction_history::insert($historyRows);
            }

            return response()->json([
                'message'        => 'Compra registrada exitosamente',
                'buy_invoice_id' => $buy->id,
                'total_amount'   => round($total, 2),
                'product_ids'    => $createdProducts,
                'items_count'    => count($detailRows),
            ], 201);
        });
    }
}
