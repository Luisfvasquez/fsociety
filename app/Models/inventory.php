<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'product_id',
        'stock',
        'minimun_stock',
        'last_updated',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
