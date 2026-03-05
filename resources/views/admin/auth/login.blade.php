@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="auth-card">
                    <h3>Admin Console Sign In</h3>
                    <p class="auth-subtitle">
                        Restricted access. Sign in with your administrator credentials.
                    </p>

                    <form class="auth-form" method="POST" action="{{ route('admin.login.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="adminEmail" class="form-label">Email address</label>
                            <input
                                id="adminEmail"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="admin@company.com"
                                required
                                autocomplete="email"
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="adminPassword" class="form-label">Password</label>
                            <input
                                id="adminPassword"
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter your password"
                                required
                                autocomplete="current-password"
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" value="1" id="rememberAdmin" name="remember">
                            <label class="form-check-label" for="rememberAdmin">Keep me signed in</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Sign In to Admin
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
