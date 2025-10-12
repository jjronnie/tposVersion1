<?php

namespace App\Http\Requests\Onboarding;

use Illuminate\Foundation\Http\FormRequest;

class StepTwoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'timezone' => ['nullable', 'string', 'timezone'],
            'tin_no' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'source' => ['nullable', 'string', 'in:facebook,x,tiktok,instagram,google,website,referral,walk_in,agent,other'],
            'source_details' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'logo.image' => 'Logo must be an image file',
            'logo.max' => 'Logo size should not exceed 2MB',
            'timezone.timezone' => 'Please select a valid timezone',
        ];
    }
}