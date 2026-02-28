<?php

namespace App\Http\Requests\Employer;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|string|in:Full Time,Part Time,Contract,Freelance',
            'salary_range' => 'nullable|string|max:255',
            'seniority' => 'required|string|in:Lead / Principal,Senior,Mid Level,Entry Level',
            'experience' => 'required|string|in:5+ years,3+ years,1-2 years,Graduate',
            'open_roles' => 'required|integer|min:1',
            'visa_sponsorship' => 'nullable|boolean',
            'summary' => 'required|string',
            'responsibilities' => 'nullable|string',
            'skills' => 'nullable|string',
            'application_email' => 'nullable|email|max:255',
            'external_apply_link' => 'nullable|url|max:255',
            'allow_quick_apply' => 'nullable|boolean',
            'status' => 'nullable|string|in:Draft,Published',
        ];
    }
}
