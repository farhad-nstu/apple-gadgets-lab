<?php

namespace App\Http\Requests;

use App\Traits\FormValidationResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductStoreRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('products', 'name')
                    ->where('category_id', $this->category_id),
            ],
            'category_id' => [   // applies exists non deleted rule to category_id
                'required',
                Rule::exists('categories', 'id')->whereNull('deleted_at')
            ],
            'price' => 'required|numeric',
        ];
    }
}
