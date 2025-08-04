<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cash_register extends Model
{
    protected $fillable = [
        'user_id',
        'opening_balance',
        'closing_balance',
        'total_cash_sales',
        'total_card_sales',
        'total_credit',
        'total_payments',
        'total_expenses',
        'total_transactions',
        'total_batches',
        'status',
        'open_date',
        'close_date',
    ];
}
