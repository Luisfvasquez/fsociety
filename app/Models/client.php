<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class client extends Model
{
    protected $fillable = [
        'name',
         'email',
          'phone_number',
           'address'
    ];

    public function sales(){
       return $this->belongsTo(sale::class);
    }

    public function sales_invoice(){
       return $this->belongsTo(sales_invoice::class);
    }
}
