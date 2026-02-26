

 @extends('layouts.app')

@section('title', 'Register')

@section('content')

  <!-- Page Title start -->
    <section class="auth-section">
      <div class="container">
        <div class="row align-items-center g-5">
          <div class="col-lg-6">
            <div class="auth-intro">
              <span class="auth-badge">Welcome Back</span>
              <h1 class="auth-title">Log in to continue your job search</h1>
              <p class="auth-copy">
                Access personalised recommendations, manage your applications,
                and stay ahead with instant updates from top employers.
              </p>
              <ul class="auth-benefits">
                <li>
                  <i class="fa-solid fa-check-circle" aria-hidden="true"></i>
                  Track your applications in real time
                </li>
                <li>
                  <i class="fa-solid fa-check-circle" aria-hidden="true"></i>
                  Discover openings tailored to your skills
                </li>
                <li>
                  <i class="fa-solid fa-check-circle" aria-hidden="true"></i>
                  Save jobs and set alerts in one dashboard
                </li>
              </ul>
            </div>
          </div>
          <div class="col-lg-5 ms-lg-auto">
            <div class="auth-card">
              <h3>Sign in to your account</h3>
              <p class="auth-subtitle">
                Enter your details below or continue with a social account.
              </p>
              <div class="auth-social">
                <a href="#." class="auth-social-btn google"
                  ><i class="fa-brands fa-google" aria-hidden="true"></i> Login
                  with Google</a
                >
                <a href="#." class="auth-social-btn linkedin"
                  ><i class="fa-brands fa-linkedin" aria-hidden="true"></i>
                  Login with LinkedIn</a
                >
              </div>
              <div class="auth-divider"><span>or</span></div>
              <form class="auth-form" action="#." method="post">
                <div class="mb-3">
                  <label for="loginEmail" class="form-label"
                    >Email address</label
                  >
                  <input
                    type="email"
                    class="form-control"
                    id="loginEmail"
                    placeholder="name@email.com"
                  />
                </div>
                <div class="mb-3">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <label for="loginPassword" class="form-label"
                      >Password</label
                    >
                    <a href="#." class="auth-link">Forgot password?</a>
                  </div>
                  <input
                    type="password"
                    class="form-control"
                    id="loginPassword"
                    placeholder="********"
                  />
                </div>
                <div class="form-check mb-4">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    value=""
                    id="rememberMe"
                  />
                  <label class="form-check-label" for="rememberMe"
                    >Keep me signed in</label
                  >
                </div>
                <button type="submit" class="btn btn-primary w-100">
                  Sign In
                </button>
              </form>
              <p class="auth-switch">
                New to JobsPortal? <a href="{{ route('register') }}">Create an account</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Page Title End -->

    @endsection