<?php

namespace App\Http\Services\Auth;

use App\Models\User;
use Illuminate\Support\Str;

class UsernameService
{
    public function generate($request): string
    {
        $base = $request->role === 'employer'
            ? Str::slug($request->company_name)
            : Str::slug($request->first_name.'-'.$request->last_name);

        if ($base === '') {
            $base = 'user';
        }

        $username = $base;
        $counter = 1;

        while (User::where('username', '@'.$username)->exists()) {
            $username = $base.$counter++;
        }

        return '@'.$username;
    }

    public function generateWithEntropy($request): string
    {
        $base = $request->role === 'employer'
            ? Str::slug($request->company_name)
            : Str::slug($request->first_name.'-'.$request->last_name);

        if ($base === '') {
            $base = 'user';
        }

        $suffix = strtolower(Str::random(6));

        return '@'.$base.'-'.$suffix;
    }
}
