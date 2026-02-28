<?php

namespace App\Http\Requests\Employer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isEmployer();
    }

    public function rules(): array
    {
        return [
            'company_name' => 'required|string|max:255',
            'industry' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'tagline' => 'nullable|string|max:255',
            'team_size' => 'nullable|string|max:100',
            'summary' => 'nullable|string|max:5000',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}
