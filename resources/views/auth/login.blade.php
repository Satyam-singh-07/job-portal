

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
              <form class="auth-form" id="loginForm">
                @csrf
                <div class="mb-3">
                  <label for="loginEmail" class="form-label"
                    >Email address</label
                  >
                  <input
                    type="email"
                    class="form-control"
                    id="loginEmail"
                    placeholder="name@email.com"
                    required
                    name="email"
                  />
                   <small class="text-danger error-message" data-error="email"></small>
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
                    required
                    name="password"
                  />
                    <small class="text-danger error-message" data-error="password"></small>
                </div>
                <div class="form-check mb-4">
                  <input
                    class="form-check-input"
                    type="checkbox"
                   
                    id="rememberMe"
                    name="remember" value="1"
                  />
                  <label class="form-check-label" for="rememberMe"
                    >Keep me signed in</label
                  >
                </div>
                <button type="submit" class="btn btn-primary w-100 submitBtn">
                   <span class="btn-text">Sign In</span>
        <span class="spinner-border spinner-border-sm d-none"></span>
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


    @section('scripts')
    <script>
    document.addEventListener("DOMContentLoaded", function() {
       const toastEl = document.getElementById('liveToast');
              const toast = new bootstrap.Toast(toastEl);

              function showToast(message, type = "success") {
                  toastEl.classList.remove("bg-success", "bg-danger");
                  toastEl.classList.add(type === "success" ? "bg-success" : "bg-danger");
                  toastEl.querySelector(".toast-body").innerText = message;
                  toast.show();
              }

    const form = document.getElementById("loginForm");

    function toggleButton(btn, loading = true) {
        if (!btn) return;

        const text = btn.querySelector(".btn-text");
        const spinner = btn.querySelector(".spinner-border");

        btn.disabled = loading;

        if (text) text.classList.toggle("d-none", loading);
        if (spinner) spinner.classList.toggle("d-none", !loading);
    }

    function clearErrors() {
        document.querySelectorAll(".error-message")
            .forEach(el => el.innerText = "");
    }

    function showErrors(errors) {
        Object.keys(errors).forEach(field => {
            const el = document.querySelector(`[data-error="${field}"]`);
            if (el) el.innerText = errors[field][0];
        });
    }

    form.addEventListener("submit", function(e) {
        e.preventDefault();

        clearErrors();

        const btn = form.querySelector('button[type="submit"]');
        toggleButton(btn, true);

        fetch("{{ route('login.post') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: new FormData(form)
        })
        .then(res => res.json())
        .then(data => {

            toggleButton(btn, false);

            if (data.status) {
              if (data.role === "candidate") {
                                      window.location.href = "/candidate/dashboard";
                                  } else {
                                      window.location.href = "/employer/dashboard";
                                  }

            }
            else if (data.otp_required) {
                alert("Please verify OTP first.");
                // optionally redirect to OTP page
                // window.location.href = '/verify-otp?user=' + data.user_id;
            }
            else {
                showToast(data.message, "danger");
            }

        })
        .catch(async err => {

            toggleButton(btn, false);

            const errorData = await err.json().catch(() => null);

            if (errorData && errorData.errors) {
                showErrors(errorData.errors);
            } else {
                alert("Something went wrong.");
            }
        });

    });

});
</script>
    @endsection