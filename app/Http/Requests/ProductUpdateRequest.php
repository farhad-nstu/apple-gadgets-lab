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
            'category_id' => [   // applies exists non deleted rule to category_id
                Rule::exists('categories', 'id')->whereNull('deleted_at')
            ],
            'price' => 'numeric',
        ];
    }
}
