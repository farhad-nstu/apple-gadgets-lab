<?php

namespace App\Http\Requests;

use App\Traits\FormValidationResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
{
    use FormValidationResponse;

    public function rules(): array
    {
        return [
            'name' => [
                'string',
                'max:100',
                Rule::unique('products', 'name')
                    ->where('category_id', $this->category_id)
                    ->ignore($this->route('product')), // Exclude the current product ID from uniqueness check
            ],
            'category_id' => 'exists:categories,id',
            'price' => 'numeric',
            'current_stock_quantity' => 'numeric'
        ];
    }
}
