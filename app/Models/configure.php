<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class configure extends Model
{
    protected $fillable = [
        'commercial_name',
        'fiscal_name',
        'company_slogan',
        'owner_name',
        'fiscal_id_type',
        'tax_name',
        'second_tax',
        'include_tax_prices',
        'company_address',
        'city',
        'postal_code',
        'phone_number',
        'fax_number',
        'mobile_phone',
        'bank_account_number',
        'use_bank_account_for_all_clients',
        'email',
        'website',
        'invoice_number_format',
        'free_field_name',
        'detect_duplicates_in_free_field',
    ];
}
