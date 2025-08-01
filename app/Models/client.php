<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

   use HasFactory;

    protected $fillable = [
      'id',
      'email',
      'name',
      'phone_number',
      'address'
    ];

    public function sales(){
       return $this->belongsTo(Sale::class);
    }

    public function sales_invoice(){
       return $this->belongsTo(Sales_invoice::class);
    }
}
