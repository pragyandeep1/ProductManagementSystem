<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
    // public function rules(): array
    // {
    //     return [
    //         'name' => 'required|string|max:250',
    //         'email' => 'required|string|email:rfc,dns|max:250|unique:users,email,' . $this->user->id,
    //         'password' => 'nullable|string|min:8|confirmed',
    //         'roles' => 'required',
    //         'contact.primary_ph' => 'required|numeric|digits:10'
    //     ];
    // }
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:250',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email,' . $this->user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required',
            'contact.primary_ph' => [
                'required',
                'numeric',
                // 'digits:10',
            ],
            'contact.postcode' => [
                'required',
                'numeric',
                // 'digits:6',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'contact.primary_ph' => [
                'required' => 'The primary phone field is required.',
                'numeric' => 'The primary phone field must be a number.',
                // 'digits' => 'The primary phone field must be 10 digits.',
            ],
            'contact.postcode' => [
                'required' => 'The postcode field is required.',
                'numeric' => 'The postcode must be a number.',
                // 'digits' => 'The postcode must be 6 digits.',
            ],
        ];
    }
}
