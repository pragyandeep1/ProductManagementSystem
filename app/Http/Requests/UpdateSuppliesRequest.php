<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSuppliesRequest extends FormRequest
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

            'name' => 'required|string|max:250|unique:supplies,name,' . $this->supply->id,
            'code' => 'required|string|max:250|unique:supplies,code,' . $this->supply->id,
            'description' => 'required|string',
            'quantity' => 'nullable|numeric|min:0',
            'meter_reading' => 'nullable|numeric|min:0'
        ];
    }
    public function messages(): array
    {
        return [
            'quantity.min' => 'The quantity must be a non-negative number.',
            'meter_reading.min' => 'The value must be a non-negative number.',
        ];
    }
}
