<?php

namespace App\Http\Controllers\Api\Buy;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuyRequest;
use App\Models\Bulk;
use App\Models\Buy_invoice;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Purchase_invoice_detail;
use App\Models\Transaction_history;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class BuyController extends Controller
{
    public $bulks = [];
    public function store(BuyRequest $request)/*  : JsonResponse */
    {
        $data       = $request->validated();
        $products   = $data['products'];
        $details    = $data['purchase_details'];
        $porcentaje = (float) $data['option']['porcentaje'];
        $this->bulks = $data['bulks'] ?? null;

        //Si vienen bultos se maneja distinto la cantidad total  a partir de los bultos
        if(empty($this->bulks)){
            // Usar array_reduce para sumar el total de la compra
            // $carry representa el acumulador, detail es el elemento actual
            $total = array_reduce($details, function ($carry, $detail) {
                return $carry + ((float) $detail['price_buy'] * (float) $detail['quantity_buy_product']);
            }, 0.0); //0.0 representa el valor inicial del acumulador
        }else{
            $total = array_reduce($this->bulks, function ($carry, $bulk) {
                return $carry + ((float) $bulk['price_per_bulk'] * (float) $bulk['quantity_bulk']);
            }, 0.0);
        }



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
                $bulk       = $this->bulks[$i] ?? null;

                if ($bulk) {
                    $unitsPerBulk = max(1, (float) $bulk['units_per_bulk']);
                    $qtyBulks     = (float) $bulk['quantity_bulk'];
                    $pricePerBulk = (float) $bulk['price_per_bulk'];
                    
                    $unitCost = $pricePerBulk / $unitsPerBulk;            // costo por unidad
                    $qtyUnits = $qtyBulks * $unitsPerBulk;                // unidades totales
                } else {
                    $unitCost = (float) ($d['price_buy'] ?? 0);
                    $qtyUnits = (float) ($d['quantity_buy_product'] ?? 0);
                }
                $salePrice = round($unitCost * (1 + $porcentaje), 2);

                // Normalizar imagen "null" (string) -> null
                $imagen = isset($p['imagen']) && $p['imagen'] !== 'null' ? $p['imagen'] : null;



                // Crear o actualizar producto
                if (!empty($p['id'])) { //si existe
                    $product = Product::findOrFail($p['id']);
                    $product->update([
                        'sale_price'    => $salePrice,
                        'date_of_entry' => $p['date_of_entry'] ?? $product->date_of_entry,
                        'due_date'      => $p['due_date'] ?? $product->due_date,
                        'category_id'   => $p['category_id'] ?? $product->category_id,
                        'description'   => $p['description'] ?? $product->description,
                        'imagen'        => $imagen ?? $product->imagen,
                    ]);
                } else { //si no existe
                    $product = Product::create([
                        'name'          => $p['name'],
                        'description'   => $p['description'] ?? null,
                        'sale_price'    => $salePrice,
                        'date_of_entry' => $p['date_of_entry'],
                        'due_date'      => $p['due_date'] ?? null,
                        'category_id'   => $p['category_id'],
                        'imagen'        => $imagen,
                    ]);
                }
                $createdProducts[] = $product->id;
                $bulk_id = null;
               if($bulk){
                 $bulkModel = Bulk::create([
                    'product_id' => $product->id,
                    'units_per_bulk'   => (int)$unitsPerBulk,
                    'quantity_bulk'      => (int)$qtyBulks,
                    'price_per_bulk'      => (float)$pricePerBulk,
                ]);

                $bulk_id = $bulkModel->id;
               }


                // Detalle (para inserción en lote)
                $detailRows[] = [
                    'buy_invoice_id'       => $buy->id,
                    'product_id'           => $product->id,
                    'quantity_buy_product' => $qtyUnits,
                    'price_buy_product'    => round($unitCost, 4),
                    'bulk_id'              => $bulk_id ?? null,
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
                $inventory->increment('stock', $qtyUnits);
                // Actualizar la fecha de última actualización
                $inventory->update(['last_updated' => $now]);

                // Historial (para inserción en lote)
                $historyRows[] = [
                    'product_id'       => $product->id,
                    'user_id'          => $userId,
                    'transaction_type' => 'buy',
                    'quantity'         => $qtyUnits,
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
