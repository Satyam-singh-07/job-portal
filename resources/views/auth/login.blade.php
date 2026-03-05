

 @extends('layouts.app')

@section('title', 'Login')

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
                Enter your email to get a one-time passcode and sign in securely.
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

                <div class="mb-3 d-none" id="otpFieldWrapper">
                  <div class="d-flex justify-content-between align-items-center">
                    <label for="loginOtp" class="form-label">One-time passcode</label>
                    <button type="button" class="btn btn-link p-0 auth-link" id="resendOtpBtn">Resend OTP</button>
                  </div>
                  <input
                    type="text"
                    class="form-control"
                    id="loginOtp"
                    placeholder="Enter 6-digit OTP"
                    inputmode="numeric"
                    maxlength="6"
                    name="otp"
                    autocomplete="one-time-code"
                  />
                  <small class="text-danger error-message" data-error="otp"></small>
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
                   <span class="btn-text">Send OTP</span>
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
      document.addEventListener("DOMContentLoaded", function () {
        const toastEl = document.getElementById("liveToast");
        const toast = toastEl ? new bootstrap.Toast(toastEl) : null;
        const form = document.getElementById("loginForm");
        const submitBtn = form?.querySelector('button[type="submit"]');
        const emailInput = document.getElementById("loginEmail");
        const otpInput = document.getElementById("loginOtp");
        const otpFieldWrapper = document.getElementById("otpFieldWrapper");
        const resendOtpBtn = document.getElementById("resendOtpBtn");
        const rememberMeInput = document.getElementById("rememberMe");

        let step = "request";
        let resendTimer = null;

        function showToast(message, type = "success") {
          if (!toastEl || !toast) return;
          toastEl.classList.remove("bg-success", "bg-danger");
          toastEl.classList.add(type === "success" ? "bg-success" : "bg-danger");
          toastEl.querySelector(".toast-body").innerText = message;
          toast.show();
        }

        function toggleButton(loading) {
          if (!submitBtn) return;

          const text = submitBtn.querySelector(".btn-text");
          const spinner = submitBtn.querySelector(".spinner-border");

          submitBtn.disabled = loading;
          if (text) text.classList.toggle("d-none", loading);
          if (spinner) spinner.classList.toggle("d-none", !loading);
        }

        function toggleResendButton(disabled, seconds = 0) {
          if (!resendOtpBtn) return;

          resendOtpBtn.disabled = disabled;

          if (!disabled) {
            resendOtpBtn.textContent = "Resend OTP";
            return;
          }

          let remaining = seconds;
          resendOtpBtn.textContent = `Resend OTP (${remaining}s)`;

          if (resendTimer) {
            clearInterval(resendTimer);
          }

          resendTimer = setInterval(() => {
            remaining -= 1;

            if (remaining <= 0) {
              clearInterval(resendTimer);
              resendTimer = null;
              toggleResendButton(false);
              return;
            }

            resendOtpBtn.textContent = `Resend OTP (${remaining}s)`;
          }, 1000);
        }

        function clearErrors() {
          document.querySelectorAll(".error-message").forEach((el) => {
            el.innerText = "";
          });
        }

        function showErrors(errors) {
          if (!errors || typeof errors !== "object") return;

          Object.keys(errors).forEach((field) => {
            const el = document.querySelector(`[data-error="${field}"]`);
            if (el) el.innerText = Array.isArray(errors[field]) ? errors[field][0] : errors[field];
          });
        }

        async function parseResponseJson(response) {
          try {
            return await response.json();
          } catch (_) {
            return null;
          }
        }

        function setOtpStep(active) {
          step = active ? "verify" : "request";

          if (otpFieldWrapper) {
            otpFieldWrapper.classList.toggle("d-none", !active);
          }

          if (emailInput) {
            emailInput.readOnly = active;
          }

          if (submitBtn) {
            const text = submitBtn.querySelector(".btn-text");
            if (text) {
              text.textContent = active ? "Verify OTP & Sign In" : "Send OTP";
            }
          }

          if (active) {
            toggleResendButton(true, 30);
            if (otpInput) otpInput.focus();
          }
        }

        function redirectByRole(role) {
          if (role === "candidate") {
            window.location.href = "/candidate/dashboard";
            return true;
          }

          if (role === "employer") {
            window.location.href = "/employer/dashboard";
            return true;
          }

          return false;
        }

        async function requestOtp(email) {
          const response = await fetch("{{ route('passwordless.request-otp') }}", {
            method: "POST",
            headers: {
              "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
              "Accept": "application/json",
              "Content-Type": "application/json"
            },
            body: JSON.stringify({ email })
          });

          return {
            response,
            data: await parseResponseJson(response),
          };
        }

        async function verifyOtp(email, otp, remember) {
          const response = await fetch("{{ route('passwordless.verify-otp') }}", {
            method: "POST",
            headers: {
              "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
              "Accept": "application/json",
              "Content-Type": "application/json"
            },
            body: JSON.stringify({ email, otp, remember })
          });

          return {
            response,
            data: await parseResponseJson(response),
          };
        }

        if (!form) return;

        resendOtpBtn?.addEventListener("click", async function () {
          clearErrors();

          const email = emailInput?.value?.trim();
          if (!email) {
            showToast("Please enter your email first.", "danger");
            return;
          }

          toggleResendButton(true, 30);

          try {
            const { data } = await requestOtp(email);
            showToast(data?.message || "If the account exists, an OTP has been sent.", "success");
          } catch (_) {
            showToast("Unable to resend OTP right now. Please try again.", "danger");
          }
        });

        form.addEventListener("submit", async function (e) {
          e.preventDefault();
          clearErrors();
          toggleButton(true);

          const email = emailInput?.value?.trim();
          const otp = otpInput?.value?.trim();
          const remember = Boolean(rememberMeInput?.checked);

          try {
            if (step === "request") {
              const { response, data } = await requestOtp(email);

              if (response.ok && data?.status) {
                showToast(data?.message || "If the account exists, an OTP has been sent.", "success");
                setOtpStep(true);
                return;
              }

              if (response.status === 422) {
                showErrors(data?.errors);
                showToast(data?.message || "Please check the highlighted fields.", "danger");
                return;
              }

              showToast(data?.message || "Unable to send OTP right now. Please try again.", "danger");
              return;
            }

            const { response, data } = await verifyOtp(email, otp, remember);

            if (response.ok && data?.status) {
              if (!redirectByRole(data.role)) {
                showToast("Login successful, but role is not recognized.", "danger");
              }
              return;
            }

            if (response.status === 422) {
              showErrors(data?.errors);
              showToast(data?.message || "Invalid or expired OTP.", "danger");
              return;
            }

            showToast(data?.message || "Unable to verify OTP right now. Please try again.", "danger");
          } catch (_) {
            showToast("Network error. Please check your connection and try again.", "danger");
          } finally {
            toggleButton(false);
          }
        });
      });
    </script>
    @endsection
