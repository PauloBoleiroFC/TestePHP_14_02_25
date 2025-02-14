<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestRequest extends FormRequest
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
            'customer_id' => 'required|exists:customers,id',
            'products' => 'required|array',
            'products.*' => 'required|exists:products,id'
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'customer_id.required' => 'The customer ID field is required.',
            'customer_id.exists' => 'The selected customer does not exist.',
            'products.required' => 'At least one product must be selected.',
            'products.array' => 'The products field must be an array.',
            'products.*.exists' => 'One or more selected products do not exist.'
        ];
    }
}
