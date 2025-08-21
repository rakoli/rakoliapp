<?php

namespace App\Http\Requests;

use App\Utils\Enums\NetworkTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NetworkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in([NetworkTypeEnum::FINANCE->value, NetworkTypeEnum::CRYPTO->value])],
            'location_code' => ['required', 'string', 'exists:locations,code'],
            'description' => ['nullable', 'string', 'max:500'],
        ];

        // Add conditional validation based on network type
        if ($this->input('type') === NetworkTypeEnum::FINANCE->value) {
            $rules = array_merge($rules, [
                'fsp_code' => ['required', 'string', 'exists:financial_service_providers,code'],
                'agent_no' => ['nullable', 'string', 'max:100'],
                'balance' => ['nullable', 'numeric', 'min:0'],
            ]);
        } elseif ($this->input('type') === NetworkTypeEnum::CRYPTO->value) {
            $rules = array_merge($rules, [
                'crypto_code' => ['required', 'string', 'exists:cryptos,code'],
                'crypto_balance' => ['nullable', 'numeric', 'min:0'],
                'exchange_rate' => ['nullable', 'numeric', 'min:0'],
            ]);
        }

        return $rules;
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Network name is required.',
            'type.required' => 'Network type is required.',
            'type.in' => 'Network type must be either Finance or Crypto.',
            'location_code.required' => 'Location is required.',
            'location_code.exists' => 'Selected location does not exist.',
            'fsp_code.required' => 'Financial service provider is required for finance networks.',
            'fsp_code.exists' => 'Selected financial service provider does not exist.',
            'crypto_code.required' => 'Crypto currency is required for crypto networks.',
            'crypto_code.exists' => 'Selected crypto currency does not exist.',
            'balance.numeric' => 'Balance must be a valid number.',
            'balance.min' => 'Balance cannot be negative.',
            'crypto_balance.numeric' => 'Crypto balance must be a valid number.',
            'crypto_balance.min' => 'Crypto balance cannot be negative.',
            'exchange_rate.numeric' => 'Exchange rate must be a valid number.',
            'exchange_rate.min' => 'Exchange rate cannot be negative.',
        ];
    }
}
