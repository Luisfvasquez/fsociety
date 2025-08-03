<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function sales_invoice_details() {
        return $this->hasMany(Sales_invoice_detail::class);
    }

    public function bulks() {
        return $this->hasMany(Bulk::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function purchase_invoice_details() {
        return $this->hasMany(Purchase_invoice_detail::class);
    }

    
}
