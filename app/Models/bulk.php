<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bulk extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_id',
        'units_per_bulk',
        'quantity_bulk',
        'price_per_bulk',
        'purchase_id',
    ];
}
