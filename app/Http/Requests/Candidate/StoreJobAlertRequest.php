<?php

namespace App\Http\Requests\Candidate;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobAlertRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isCandidate();
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('min_salary')) {
            $this->merge([
                'min_salary' => preg_replace('/[^0-9]/', '', (string) $this->input('min_salary')),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'role_keywords' => 'required|string|max:255',
            'locations' => 'nullable|string|max:255',
            'job_type' => 'required|string|in:any,full_time,contract,freelance,internship',
            'frequency' => 'required|string|in:instant,daily,weekly',
            'min_salary' => 'nullable|integer|min:0|max:100000000',
            'delivery_channel' => 'required|string|in:email,in_app,sms',
            'notes' => 'nullable|string|max:2000',
        ];
    }
}
