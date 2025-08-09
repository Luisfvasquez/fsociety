<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'buy_invoice.supplier_id' => 'required|integer|exists:suppliers,id',
        'buy_invoice.date_buy'    => 'required|date',
        'buy_invoice.status'      => 'required|string|in:paid,pending,cancelled',

        'products'                => 'required|array|min:1',
        'products.*.id'           => 'nullable|integer',
        'products.*.name'         => 'required_without:products.*.id|string',
        'products.*.description'  => 'nullable|string',
        'products.*.date_of_entry'=> 'required|date',
        'products.*.due_date'     => 'nullable|date',
        'products.*.category_id'  => 'required|integer|exists:categories,id',
        'products.*.imagen'       => 'nullable',

        'purchase_details'                         => 'required|array|min:1',
        'purchase_details.*.quantity_buy_product'  => 'required|numeric|min:1',
        'purchase_details.*.price_buy'             => 'required|numeric|min:0',
        'purchase_details.*.bulk'                  => 'nullable',

        'option.porcentaje'       => 'required|numeric|min:0',
        ];
    }
}
