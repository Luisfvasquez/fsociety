<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $fillable = [
        'id',
        'name',
        'purchase_price',
        'sale_price',
        'date_of_entry',
        'due_date',
        'category_id',
        'image',
    ];

    public function categories()
    {
        return $this->belongsTo(category::class);
    }

    public function sales()
    {
        return $this->hasMany(sale::class);
    }

    public function sales_invoice_details() {
        return $this->hasMany(sales_invoice_detail::class);
    }

    public function bulks() {
        return $this->hasMany(bulk::class);
    }

    public function inventories()
    {
        return $this->hasMany(inventory::class);
    }

    public function purchases()
    {
        return $this->hasMany(purchase::class);
    }

    public function purchase_invoice_details() {
        return $this->hasMany(purchase_invoice_detail::class);
    }

    
}
