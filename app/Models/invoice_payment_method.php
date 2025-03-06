<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class invoice_payment_method extends Model
{
    protected $fillable = [ 
        'sales_invoice_id',
        'payment_method_id',
        'total_amount',
        'currency_id',
        'payment_date'
    ];

    public function sales_invoice()
    {
        return $this->belongsTo(sales_invoice_detail::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(payment_method::class);
    }

    public function currency()
    {
        return $this->belongsTo(currency::class);
    }
}
