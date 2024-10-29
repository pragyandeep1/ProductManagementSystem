<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusinessRequest extends FormRequest
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
            'name' => 'required|string|max:250|unique:businesses,name',
            'code' => 'required|string|max:250|unique:businesses,code',
            'description' => 'required|string',
            'quantity' => 'nullable|numeric',
            'meter_reading' => 'nullable|numeric'
        ];
    }
}
