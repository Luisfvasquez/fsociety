<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buy_invoice extends Model
{
    protected $fillable =[
        'supplier_id',
        'date_buy',
        'status',
        'total_amount',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchase_invoice_detail()
    {
        return $this->hasMany(Purchase_invoice_detail::class);
    }

}
