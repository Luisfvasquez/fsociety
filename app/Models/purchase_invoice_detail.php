<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase_invoice_detail extends Model
{
    protected $fillable = [
        'buy_invoice_id',
        'product_id',
        'quantity_buy_product',
        'price_buy_product',
        'bulk_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);    
    }

    public function buy_invoice()
    {
        return $this->belongsTo(Buy_invoice::class);    
    }

    public function bulk()
    {
        return $this->belongsTo(Bulk::class);
    }
}
