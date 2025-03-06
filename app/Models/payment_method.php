<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class payment_method extends Model
{
    protected $fillable = [
        'name_method',
        'currency_id',
    ];

    public function currency()
    {
        return $this->belongsTo(currency::class);
    }

    public function invoice_payment_method()
    {
        return $this->hasMany(invoice_payment_method::class);
    }

    public function payments()
    {
        return $this->hasMany(payment::class);
    }
}
