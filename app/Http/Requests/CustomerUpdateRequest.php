<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
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
            'id'=>['exists:customers,id'],
            'name' =>['required', 'max:255', 'min:10'],
            'email' => ['required', 'unique:customers,email,'.$this->input('id').'ID', 'email', 'max:255'],
            'address' =>['required', 'max:255', 'min:10'],
            'telephone_number' => ['required', 'max:25', 'min:7'],
        ];
    }
}
