<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow all users to submit forms
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'salesRepName' => 'required|string|max:255',
            'agentName' => 'required|string|max:255',
            'phoneNumber' => 'required|string|max:20',
            'location' => 'required|string|max:255',
            'gpsCoordinates' => 'nullable|string|max:255',
            'locationCaptured' => 'boolean',
            'businessName' => 'required|string|max:255',
            'mnoUsed' => 'array',
            'mnoUsed.*' => 'string|max:50',
            'otherMno' => 'nullable|string|max:255',
            'vodacomTill' => 'nullable|string|max:50',
            'airtelTill' => 'nullable|string|max:50',
            'tigoTill' => 'nullable|string|max:50',
            'bankWallet' => 'nullable|string|max:255',
            'visitOutcome' => 'required|string|max:255',
            'declineReason' => 'nullable|string|max:500',
            'keyConcerns' => 'nullable|string|max:1000',
            'suggestions' => 'nullable|string|max:1000',
            'dailyChallenges' => 'nullable|string|max:1000',
            'rakoliSuggestions' => 'nullable|string|max:1000',
            'agentSignature' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'salesRepName.required' => 'Sales representative name is required.',
            'agentName.required' => 'Agent name is required.',
            'phoneNumber.required' => 'Phone number is required.',
            'location.required' => 'Location is required.',
            'businessName.required' => 'Business name is required.',
            'visitOutcome.required' => 'Visit outcome is required.',
            'mnoUsed.array' => 'MNO used must be an array.',
            'phoneNumber.max' => 'Phone number cannot exceed 20 characters.',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'salesRepName' => 'sales representative name',
            'agentName' => 'agent name',
            'phoneNumber' => 'phone number',
            'gpsCoordinates' => 'GPS coordinates',
            'locationCaptured' => 'location captured status',
            'businessName' => 'business name',
            'mnoUsed' => 'MNO providers used',
            'otherMno' => 'other MNO provider',
            'vodacomTill' => 'Vodacom till number',
            'airtelTill' => 'Airtel till number',
            'tigoTill' => 'Tigo till number',
            'bankWallet' => 'bank wallet',
            'visitOutcome' => 'visit outcome',
            'declineReason' => 'decline reason',
            'keyConcerns' => 'key concerns',
            'suggestions' => 'suggestions',
            'dailyChallenges' => 'daily challenges',
            'rakoliSuggestions' => 'Rakoli suggestions',
            'agentSignature' => 'agent signature',
        ];
    }
}
