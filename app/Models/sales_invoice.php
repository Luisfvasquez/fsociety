<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales_invoice extends Model
{
    protected $fillable = [
        'client_id',
        'reference',
        'status',
    ];

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function sales_invoice_detail() {
        return $this->hasMany(Sales_invoice_detail::class);
    }
}
