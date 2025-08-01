<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credit_sale extends Model
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
        return $this->belongsTo(Sale::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
