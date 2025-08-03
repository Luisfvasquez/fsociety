<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        if($this->product) {
            $product_id = ',' . $this->product;
        }else{
            $product_id = '';
        }

        return [
            'name' => 'required|string|min:3|max:255',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'date_of_entry' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:date_of_entry',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048', // 2MB max
            // 'description' => 'nullable|string', // Uncomment if description is needed
        ];
    }
}
