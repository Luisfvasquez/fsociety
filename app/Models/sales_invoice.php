<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sales_invoice extends Model
{
    protected $fillable = [
        'client_id',
        'reference',
        'status',
    ];

    public function client() {
        return $this->belongsTo(client::class);
    }

    public function sales_invoice_detail() {
        return $this->hasMany(sales_invoice_detail::class);
    }
}
