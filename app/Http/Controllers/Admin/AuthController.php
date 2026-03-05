<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(): View
    {
        return view('admin.auth.login');
    }

    public function store(AdminLoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        $admin = User::query()
            ->where('email', $credentials['email'])
            ->whereHas('role', function ($query) {
                $query->where('name', 'admin');
            })
            ->first();

        if (! $admin || ! Hash::check($credentials['password'], (string) $admin->password)) {
            return back()
                ->withErrors(['email' => 'Invalid credentials.'])
                ->onlyInput('email');
        }

        Auth::login($admin, (bool) ($credentials['remember'] ?? false));
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function destroy(): RedirectResponse
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
