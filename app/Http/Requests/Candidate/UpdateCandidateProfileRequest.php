<?php

namespace App\Http\Requests\Candidate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCandidateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isCandidate();
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'title' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'preferred_locations' => 'nullable|string|max:255',
            'portfolio_url' => 'nullable|url|max:255',
            'website' => 'nullable|url|max:255',
            'experience_level' => 'nullable|string|max:255',
            'current_company' => 'nullable|string|max:255',
            'notice_period' => 'nullable|string|max:255',
            'desired_employment_type' => 'nullable|string|max:255',
            'salary_expectation' => 'nullable|string|max:255',
            'work_preference' => 'nullable|string|max:255',
            'target_roles' => 'nullable|string',
            'summary' => 'nullable|string|max:5000',
            'skills_input' => 'nullable|string|max:1000',
            'social_links' => 'nullable|array',
            'social_links.*' => 'nullable|url',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ];
    }
}
