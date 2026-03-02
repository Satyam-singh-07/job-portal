<?php

namespace App\Http\Requests\Candidate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobAlertStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isCandidate();
    }

    public function rules(): array
    {
        return [
            'is_active' => 'required|boolean',
        ];
    }
}
