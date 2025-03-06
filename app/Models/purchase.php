<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class purchase extends Model
{
    protected $fillable = [
        'product_id',
        'supplier_id',
        'purchase_date',
        'total_amount',
    ];

    public function product()
    {
        return $this->belongsTo(product::class);
    }

    public function supplier()
    {
        return $this->belongsTo(supplier::class);
    }

    public function bulk(){
        return $this->hasMany(bulk::class);
    }
}
