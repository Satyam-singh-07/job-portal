  @extends('layouts.app')

@section('title', 'Register')

@section('content')
  
  <!-- Page Title start -->
    <section class="auth-section auth-signup">
      <div class="container">
        <div class="row align-items-center g-5">
          <div class="col-lg-6">
            <div class="auth-intro">
              <span class="auth-badge">Create Account</span>
              <h1 class="auth-title">
                Join thousands of professionals hiring and getting hired
              </h1>
              <p class="auth-copy">
                Build a profile that stands out, connect with employers, and
                unlock tailored recommendations to accelerate your career
                journey.
              </p>
              <ul class="auth-benefits">
                <li>
                  <i class="fa-solid fa-check-circle" aria-hidden="true"></i>
                  Access curated jobs from verified companies
                </li>
                <li>
                  <i class="fa-solid fa-check-circle" aria-hidden="true"></i>
                  Showcase your portfolio and skill badges
                </li>
                <li>
                  <i class="fa-solid fa-check-circle" aria-hidden="true"></i>
                  Collaborate with hiring teams in real time
                </li>
              </ul>
            </div>
          </div>
          <div class="col-lg-5 ms-lg-auto">
            <div class="auth-card">
              <h3>Create your free account</h3>
              <p class="auth-subtitle">
                Start as a candidate or an employer. Switch anytime.
              </p>
              <div class="auth-social">
                <a href="#." class="auth-social-btn google"
                  ><i class="fa-brands fa-google" aria-hidden="true"></i> Sign
                  up with Google</a
                >
                <a href="#." class="auth-social-btn linkedin"
                  ><i class="fa-brands fa-linkedin" aria-hidden="true"></i> Sign
                  up with LinkedIn</a
                >
              </div>
              <div class="auth-divider"><span>or</span></div>
              <div
                class="auth-toggle nav nav-pills"
                id="registerTab"
                role="tablist"
              >
                <button
                  class="auth-toggle-btn nav-link active"
                  id="candidate-tab"
                  data-bs-toggle="pill"
                  data-bs-target="#registerCandidate"
                  type="button"
                  role="tab"
                  aria-controls="registerCandidate"
                  aria-selected="true"
                >
                  Candidate
                </button>
                <button
                  class="auth-toggle-btn nav-link"
                  id="employer-tab"
                  data-bs-toggle="pill"
                  data-bs-target="#registerEmployer"
                  type="button"
                  role="tab"
                  aria-controls="registerEmployer"
                  aria-selected="false"
                >
                  Employer
                </button>
              </div>
              <div class="tab-content" id="registerTabContent">
                <div
                  class="tab-pane fade show active"
                  id="registerCandidate"
                  role="tabpanel"
                  aria-labelledby="candidate-tab"
                >
                  <form class="auth-form" action="#." method="post">
                    <div class="row g-3">
                      <div class="col-sm-6">
                        <label for="candidateFirst" class="form-label"
                          >First name</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          id="candidateFirst"
                          placeholder="Samantha"
                        />
                      </div>
                      <div class="col-sm-6">
                        <label for="candidateLast" class="form-label"
                          >Last name</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          id="candidateLast"
                          placeholder="Jenkins"
                        />
                      </div>
                      <div class="col-sm-12">
                        <label for="candidateEmail" class="form-label"
                          >Email address</label
                        >
                        <input
                          type="email"
                          class="form-control"
                          id="candidateEmail"
                          placeholder="name@email.com"
                        />
                      </div>
                      <div class="col-sm-12">
                        <label for="candidatePassword" class="form-label"
                          >Password</label
                        >
                        <input
                          type="password"
                          class="form-control"
                          id="candidatePassword"
                          placeholder="Create a strong password"
                        />
                      </div>
                      <div class="col-sm-12">
                        <label for="candidateRole" class="form-label"
                          >Desired role</label
                        >
                        <select class="form-select" id="candidateRole">
                          <option selected>Product Designer</option>
                          <option>Frontend Developer</option>
                          <option>Data Analyst</option>
                          <option>Marketing Specialist</option>
                          <option>Customer Success</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-check auth-policy mt-4">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        value=""
                        id="candidatePolicy"
                      />
                      <label class="form-check-label" for="candidatePolicy"
                        >I agree to the
                        <a href="#." class="auth-link">Terms of Service</a> and
                        <a href="#." class="auth-link">Privacy Policy</a
                        >.</label
                      >
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-4">
                      Create Candidate Account
                    </button>
                  </form>
                </div>
                <div
                  class="tab-pane fade"
                  id="registerEmployer"
                  role="tabpanel"
                  aria-labelledby="employer-tab"
                >
                  <form class="auth-form" action="#." method="post">
                    <div class="row g-3">
                      <div class="col-sm-12">
                        <label for="companyName" class="form-label"
                          >Company name</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          id="companyName"
                          placeholder="Acme Studios"
                        />
                      </div>
                      <div class="col-sm-12">
                        <label for="companyWebsite" class="form-label"
                          >Website</label
                        >
                        <input
                          type="url"
                          class="form-control"
                          id="companyWebsite"
                          placeholder="https://yourcompany.com/"
                        />
                      </div>
                      <div class="col-sm-12">
                        <label for="companyEmail" class="form-label"
                          >Work email</label
                        >
                        <input
                          type="email"
                          class="form-control"
                          id="companyEmail"
                          placeholder="you@company.com"
                        />
                      </div>
                      <div class="col-sm-6">
                        <label for="employerPassword" class="form-label"
                          >Password</label
                        >
                        <input
                          type="password"
                          class="form-control"
                          id="employerPassword"
                          placeholder="Create a password"
                        />
                      </div>
                      <div class="col-sm-6">
                        <label for="employerTeamSize" class="form-label"
                          >Team size</label
                        >
                        <select class="form-select" id="employerTeamSize">
                          <option selected>1-10 employees</option>
                          <option>11-50 employees</option>
                          <option>51-200 employees</option>
                          <option>200+ employees</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-check auth-policy mt-4">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        value=""
                        id="employerPolicy"
                      />
                      <label class="form-check-label" for="employerPolicy"
                        >I accept the
                        <a href="#." class="auth-link">Terms</a> and confirm I
                        have hiring authority.</label
                      >
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-4">
                      Create Employer Account
                    </button>
                  </form>
                </div>
              </div>
              <p class="auth-switch">
                Already have an account? <a href="login.html">Sign in</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Page Title End -->

    @endsection