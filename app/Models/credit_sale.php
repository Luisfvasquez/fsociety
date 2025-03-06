<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class credit_sale extends Model
{
    protected $fillable = [
        'sale_id',
        'due_date',
        'amount_due',
        'status',
        'installments',
        'installment_amount',
    ];

    public function sale()
    {
        return $this->belongsTo(sale::class);
    }

    public function payments()
    {
        return $this->hasMany(payment::class);
    }
}
