<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bulk extends Model
{
    protected $fillable = [
        'product_id',
        'units_per_bulk',
        'quantity_bulk',
        'price_per_bulk',
        'purchase_id',
    ];
}
