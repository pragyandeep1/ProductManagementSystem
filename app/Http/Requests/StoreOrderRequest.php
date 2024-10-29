<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'name' => 'required|string|max:250|unique:orders,name',
            'code' => 'required|string|max:250|unique:orders,code',
            'description' => 'nullable|string',
            'priority' => 'nullable|numeric|min:0'
        ];
    }
    public function messages(): array
    {
        return [
            'priority.min' => 'The priority must be a non-negative number.'
        ];
    }
}
