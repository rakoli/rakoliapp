<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FloatExchangeRequest extends FormRequest
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
            'from_network_code' => 'required|string|exists:networks,code',
            'to_network_code' => 'required|string|exists:networks,code|different:from_network_code',
            'amount' => 'required|numeric|min:1',
            'notes' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'from_network_code.required' => 'Source network is required',
            'from_network_code.exists' => 'Source network does not exist',
            'to_network_code.required' => 'Destination network is required',
            'to_network_code.exists' => 'Destination network does not exist',
            'to_network_code.different' => 'Source and destination networks must be different',
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be a number',
            'amount.min' => 'Amount must be at least 1',
        ];
    }
}
