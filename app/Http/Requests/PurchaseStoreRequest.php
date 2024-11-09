<?php

namespace App\Http\Requests;

use App\Traits\FormValidationResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseStoreRequest extends FormRequest
{
    use FormValidationResponse;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'supplier_id' => [   // Applies exists rule to each item in the array
                'required',
                Rule::exists('suppliers', 'id')->whereNull('deleted_at')
            ],
            'product_id' => 'required|array',
            'product_id.*' => [   // Applies numeric and exists non deleted rule to each item in the array
                'numeric',
                Rule::exists('products', 'id')->whereNull('deleted_at')
            ],
            'quantity' => 'required|array',
            'quantity.*' => 'numeric', // Applies numeric rule to each item in the array
            'unit_price' => 'required|array',
            'unit_price.*' => 'numeric', // Applies numeric rule to each item in the array
        ];
    }
}
