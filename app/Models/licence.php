<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Licence extends Model
{
    protected $fillable = [
        'license_key',
        'start_date',
        'end_date',
        'status',
    ];
}
