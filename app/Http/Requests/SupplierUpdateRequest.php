<?php

namespace App\Http\Requests;

use App\Traits\FormValidationResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierUpdateRequest extends FormRequest
{
    use FormValidationResponse;

    public function rules(): array
    {
        return [
            'name' => 'string|max:100',
            'contact_info' => [
                'string',
                'max:255',
                Rule::unique('suppliers', 'contact_info')
                    ->ignore($this->route('supplier')), // Exclude the current supplier ID from uniqueness check
            ],
            'address' => 'string|max:255',
        ];
    }
}
