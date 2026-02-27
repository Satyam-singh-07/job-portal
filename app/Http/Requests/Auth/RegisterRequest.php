<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'role' => 'required|in:candidate,employer',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'company_name' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'team_size' => 'nullable|string'
        ];
    }
}