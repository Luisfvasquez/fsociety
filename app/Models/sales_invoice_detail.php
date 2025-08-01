<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales_invoice_detail extends Model
{
    protected $fillable = [
        'sales_invoice_id',
        'product_id',
        'quantity_buy_product',
        'price_product',
    ];

    public function sales_invoice() {
        return $this->belongsTo(Sales_invoice::class);
    }

    public function invoice_payment_methods() {
        return $this->hasMany(Invoice_payment_method::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

        
}
