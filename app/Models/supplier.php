<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    
    // Define the fillable attributes for the supplier model
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone_number',
        'address',
    ];
}
