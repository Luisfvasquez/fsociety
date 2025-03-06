<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sale extends Model
{
    protected $fillable = [
        'box_number',
        'product_id',
        'client_id',
        'total_amount',
        'status',
        'sale_date',
    ];

    public function client() {
        return $this->belongsTo(client::class);
    }
}
