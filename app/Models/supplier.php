<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'address',
    ];
}
