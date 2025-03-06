<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    protected $fillable = [
        'credit_sale_id',
        'payment_date',
        'amount_paid',
        'payment_method_id',
        'currency_id',
    ];

    public function credit_sale()
    {
        return $this->belongsTo(credit_sale::class);
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
