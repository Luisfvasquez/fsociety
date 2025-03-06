<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class buy_invoice extends Model
{
    protected $fillable =[
        'supplier_id',
        'purchase_date_invoice',
        'status',
        'total_amount',
    ];

    public function supplier()
    {
        return $this->belongsTo(supplier::class);
    }

    public function purchase_invoice_detail()
    {
        return $this->hasMany(purchase_invoice_detail::class);
    }

}
