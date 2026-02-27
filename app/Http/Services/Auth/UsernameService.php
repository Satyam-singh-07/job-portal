<?php

namespace App\Http\Services\Auth;

use App\Models\User;
use Illuminate\Support\Str;

class UsernameService
{
    public function generate($request)
    {
        $base = $request->role === 'employer'
            ? Str::slug($request->company_name)
            : Str::slug($request->first_name.'-'.$request->last_name);

        $username = $base;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $base.$counter++;
        }

        return '@'.$username;
    }
}
