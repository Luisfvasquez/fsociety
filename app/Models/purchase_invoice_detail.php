<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class purchase_invoice_detail extends Model
{
    protected $fillable = [
        'buy_invoice_id',
        'product_id',
        'quantity_buy_product',
        'price_buy_product'
    ];

    public function product()
    {
        return $this->belongsTo(product::class);    
    }

    public function buy_invoice()
    {
        return $this->belongsTo(buy_invoice::class);    
    }
}
