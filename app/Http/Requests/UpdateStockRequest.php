<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStockRequest extends FormRequest
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
            'stocks_parent_facility' => 'required',
            'stocks_qty_on_hand' => 'nullable|numeric|min:0',
            'stocks_min_qty' => 'nullable|numeric|min:0',
            'stocks_max_qty' => 'nullable|numeric|min:0',
            'initial_price' => 'nullable|numeric|min:0',
        ];
    }
    public function messages(): array
    {
        return [
            'stocks_parent_facility' => 'The asset field is required.',
            'stocks_qty_on_hand.min' => 'The quantity on hand field must be a positive number.',
            'stocks_min_qty.min' => 'The minimum quantity field must be a positive number.',
            'stocks_max_qty.min' => 'The maximum quantity field must be a positive number.',
            'initial_price.min' => 'The initial price field must be a positive number.',
            
        ];
    }
}
