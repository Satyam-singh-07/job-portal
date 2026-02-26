  @extends('layouts.app')

  @section('title', 'Register')


  @section('content')

      <style>
          .otp-container {
              max-width: 420px;
              margin: 100px auto;
              padding: 40px;
              border-radius: 12px;
              box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
              text-align: center;
              background: #fff;
          }

          .otp-subtext {
              color: #6c757d;
              margin-bottom: 25px;
          }

          .otp-inputs {
              display: flex;
              justify-content: space-between;
              gap: 10px;
          }

          .otp-box {
              width: 50px;
              height: 55px;
              font-size: 22px;
              text-align: center;
              border: 1px solid #ddd;
              border-radius: 8px;
              transition: 0.2s;
          }

          .otp-box:focus {
              border-color: #0d6efd;
              box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.15);
              outline: none;
          }

          .otp-footer {
              margin-top: 20px;
              font-size: 14px;
          }
      </style>
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
                              <a href="#." class="auth-social-btn google"><i class="fa-brands fa-google"
                                      aria-hidden="true"></i> Sign
                                  up with Google</a>
                              <a href="#." class="auth-social-btn linkedin"><i class="fa-brands fa-linkedin"
                                      aria-hidden="true"></i> Sign
                                  up with LinkedIn</a>
                          </div>
                          <div class="auth-divider"><span>or</span></div>
                          <div class="auth-toggle nav nav-pills" id="registerTab" role="tablist">
                              <button class="auth-toggle-btn nav-link active" id="candidate-tab" data-bs-toggle="pill"
                                  data-bs-target="#registerCandidate" type="button" role="tab"
                                  aria-controls="registerCandidate" aria-selected="true">
                                  Candidate
                              </button>
                              <button class="auth-toggle-btn nav-link" id="employer-tab" data-bs-toggle="pill"
                                  data-bs-target="#registerEmployer" type="button" role="tab"
                                  aria-controls="registerEmployer" aria-selected="false">
                                  Employer
                              </button>
                          </div>
                          <div class="tab-content" id="registerTabContent">
                              <div class="tab-pane fade show active" id="registerCandidate" role="tabpanel"
                                  aria-labelledby="candidate-tab">


                                  <form class="auth-form" method="post" id="candidateForm">
                                      @csrf
                                      <input type="hidden" name="role" value="candidate">
                                      <div class="row g-3">
                                          <div class="col-sm-6">
                                              <label for="candidateFirst" class="form-label">First name</label>
                                              <input type="text" class="form-control" name="first_name"
                                                  id="candidateFirst" placeholder="Samantha" required />
                                          </div>
                                          <div class="col-sm-6">
                                              <label for="candidateLast" class="form-label">Last name</label>
                                              <input type="text" class="form-control" name="last_name" id="candidateLast"
                                                  placeholder="Jenkins" required />
                                          </div>
                                          <div class="col-sm-12">
                                              <label for="candidateEmail" class="form-label">Email address</label>
                                              <input type="email" class="form-control" name="email" id="candidateEmail"
                                                  placeholder="name@email.com" required />
                                              <small id="emailMessage" class="form-text"></small>
                                              <small class="text-danger error-message" data-error="email"></small>
                                          </div>
                                          <div class="col-sm-12">
                                              <label for="candidatePassword" class="form-label">Password</label>
                                              <input type="password" class="form-control" name="password"
                                                  id="candidatePassword" placeholder="Create a strong password" required />
                                          </div>
                                          <div class="col-sm-12">
                                              <label for="candidateRole" class="form-label">Desired role</label>
                                              <select  class="form-select" name="desired_role" id="candidateRole" required>

                                                  <option value="">-- Select Desired role --</option>

                                                  <!-- Top Management -->
                                                  <option value="founder">Founder</option>
                                                  <option value="co_founder">Co-Founder</option>
                                                  <option value="chairman">Chairman</option>
                                                  <option value="vice_chairman">Vice Chairman</option>
                                                  <option value="chief_executive_officer">Chief Executive Officer (CEO)
                                                  </option>
                                                  <option value="chief_operating_officer">Chief Operating Officer (COO)
                                                  </option>
                                                  <option value="chief_technology_officer">Chief Technology Officer (CTO)
                                                  </option>
                                                  <option value="chief_financial_officer">Chief Financial Officer (CFO)
                                                  </option>
                                                  <option value="chief_marketing_officer">Chief Marketing Officer (CMO)
                                                  </option>
                                                  <option value="chief_information_officer">Chief Information Officer (CIO)
                                                  </option>
                                                  <option value="chief_product_officer">Chief Product Officer</option>
                                                  <option value="managing_director">Managing Director</option>
                                                  <option value="executive_director">Executive Director</option>
                                                  <option value="director_operations">Director - Operations</option>
                                                  <option value="director_hr">Director - HR</option>
                                                  <option value="director_marketing">Director - Marketing</option>
                                                  <option value="general_manager">General Manager</option>
                                                  <option value="assistant_general_manager">Assistant General Manager
                                                  </option>
                                                  <option value="business_head">Business Head</option>
                                                  <option value="unit_head">Unit Head</option>

                                                  <!-- IT & Software -->
                                                  <option value="software_engineer">Software Engineer</option>
                                                  <option value="senior_software_engineer">Senior Software Engineer
                                                  </option>
                                                  <option value="junior_software_engineer">Junior Software Engineer
                                                  </option>
                                                  <option value="software_developer">Software Developer</option>
                                                  <option value="frontend_developer">Frontend Developer</option>
                                                  <option value="backend_developer">Backend Developer</option>
                                                  <option value="full_stack_developer">Full Stack Developer</option>
                                                  <option value="mobile_app_developer">Mobile App Developer</option>
                                                  <option value="android_developer">Android Developer</option>
                                                  <option value="ios_developer">iOS Developer</option>
                                                  <option value="ui_ux_designer">UI/UX Designer</option>
                                                  <option value="web_designer">Web Designer</option>
                                                  <option value="devops_engineer">DevOps Engineer</option>
                                                  <option value="cloud_engineer">Cloud Engineer</option>
                                                  <option value="cloud_architect">Cloud Architect</option>
                                                  <option value="data_scientist">Data Scientist</option>
                                                  <option value="data_analyst">Data Analyst</option>
                                                  <option value="machine_learning_engineer">Machine Learning Engineer
                                                  </option>
                                                  <option value="ai_engineer">AI Engineer</option>
                                                  <option value="cyber_security_analyst">Cyber Security Analyst</option>
                                                  <option value="ethical_hacker">Ethical Hacker</option>
                                                  <option value="blockchain_developer">Blockchain Developer</option>
                                                  <option value="game_developer">Game Developer</option>
                                                  <option value="qa_engineer">QA Engineer</option>
                                                  <option value="automation_tester">Automation Tester</option>
                                                  <option value="manual_tester">Manual Tester</option>
                                                  <option value="it_support_engineer">IT Support Engineer</option>
                                                  <option value="system_administrator">System Administrator</option>
                                                  <option value="network_engineer">Network Engineer</option>
                                                  <option value="database_administrator">Database Administrator</option>
                                                  <option value="erp_consultant">ERP Consultant</option>
                                                  <option value="sap_consultant">SAP Consultant</option>
                                                  <option value="business_analyst">Business Analyst</option>
                                                  <option value="scrum_master">Scrum Master</option>
                                                  <option value="product_owner">Product Owner</option>
                                                  <option value="product_manager">Product Manager</option>
                                                  <option value="technical_architect">Technical Architect</option>
                                                  <option value="solution_architect">Solution Architect</option>

                                                  <!-- Marketing & Sales -->
                                                  <option value="marketing_manager">Marketing Manager</option>
                                                  <option value="digital_marketing_manager">Digital Marketing Manager
                                                  </option>
                                                  <option value="seo_specialist">SEO Specialist</option>
                                                  <option value="social_media_manager">Social Media Manager</option>
                                                  <option value="performance_marketing_manager">Performance Marketing
                                                      Manager</option>
                                                  <option value="content_writer">Content Writer</option>
                                                  <option value="copywriter">Copywriter</option>
                                                  <option value="brand_manager">Brand Manager</option>
                                                  <option value="sales_manager">Sales Manager</option>
                                                  <option value="area_sales_manager">Area Sales Manager</option>
                                                  <option value="regional_sales_manager">Regional Sales Manager</option>
                                                  <option value="business_development_manager">Business Development Manager
                                                  </option>
                                                  <option value="relationship_manager">Relationship Manager</option>
                                                  <option value="account_manager">Account Manager</option>
                                                  <option value="sales_executive">Sales Executive</option>
                                                  <option value="telecaller">Telecaller</option>

                                                  <!-- Finance -->
                                                  <option value="accountant">Accountant</option>
                                                  <option value="senior_accountant">Senior Accountant</option>
                                                  <option value="chartered_accountant">Chartered Accountant</option>
                                                  <option value="financial_analyst">Financial Analyst</option>
                                                  <option value="finance_manager">Finance Manager</option>
                                                  <option value="investment_banker">Investment Banker</option>
                                                  <option value="auditor">Auditor</option>
                                                  <option value="tax_consultant">Tax Consultant</option>
                                                  <option value="risk_manager">Risk Manager</option>
                                                  <option value="credit_analyst">Credit Analyst</option>

                                                  <!-- HR -->
                                                  <option value="hr_manager">HR Manager</option>
                                                  <option value="hr_executive">HR Executive</option>
                                                  <option value="talent_acquisition_specialist">Talent Acquisition
                                                      Specialist</option>
                                                  <option value="recruiter">Recruiter</option>
                                                  <option value="payroll_executive">Payroll Executive</option>
                                                  <option value="training_manager">Training Manager</option>
                                                  <option value="hr_business_partner">HR Business Partner</option>

                                                  <!-- Engineering -->
                                                  <option value="civil_engineer">Civil Engineer</option>
                                                  <option value="mechanical_engineer">Mechanical Engineer</option>
                                                  <option value="electrical_engineer">Electrical Engineer</option>
                                                  <option value="electronics_engineer">Electronics Engineer</option>
                                                  <option value="chemical_engineer">Chemical Engineer</option>
                                                  <option value="production_engineer">Production Engineer</option>
                                                  <option value="quality_engineer">Quality Engineer</option>
                                                  <option value="site_engineer">Site Engineer</option>
                                                  <option value="maintenance_engineer">Maintenance Engineer</option>

                                                  <!-- Healthcare -->
                                                  <option value="doctor">Doctor</option>
                                                  <option value="surgeon">Surgeon</option>
                                                  <option value="nurse">Nurse</option>
                                                  <option value="pharmacist">Pharmacist</option>
                                                  <option value="medical_officer">Medical Officer</option>
                                                  <option value="lab_technician">Lab Technician</option>
                                                  <option value="physiotherapist">Physiotherapist</option>

                                                  <!-- Education -->
                                                  <option value="teacher">Teacher</option>
                                                  <option value="assistant_teacher">Assistant Teacher</option>
                                                  <option value="lecturer">Lecturer</option>
                                                  <option value="professor">Professor</option>
                                                  <option value="principal">Principal</option>
                                                  <option value="trainer">Trainer</option>

                                                  <!-- Legal -->
                                                  <option value="lawyer">Lawyer</option>
                                                  <option value="advocate">Advocate</option>
                                                  <option value="legal_advisor">Legal Advisor</option>
                                                  <option value="compliance_officer">Compliance Officer</option>

                                                  <!-- Operations -->
                                                  <option value="operations_manager">Operations Manager</option>
                                                  <option value="logistics_manager">Logistics Manager</option>
                                                  <option value="supply_chain_manager">Supply Chain Manager</option>
                                                  <option value="warehouse_manager">Warehouse Manager</option>
                                                  <option value="procurement_manager">Procurement Manager</option>

                                                  <!-- Creative -->
                                                  <option value="graphic_designer">Graphic Designer</option>
                                                  <option value="video_editor">Video Editor</option>
                                                  <option value="photographer">Photographer</option>
                                                  <option value="animator">Animator</option>
                                                  <option value="creative_director">Creative Director</option>

                                                  <!-- Hospitality -->
                                                  <option value="hotel_manager">Hotel Manager</option>
                                                  <option value="restaurant_manager">Restaurant Manager</option>
                                                  <option value="chef">Chef</option>
                                                  <option value="head_chef">Head Chef</option>
                                                  <option value="housekeeping_manager">Housekeeping Manager</option>

                                                  <!-- Government -->
                                                  <option value="government_officer">Government Officer</option>
                                                  <option value="police_officer">Police Officer</option>
                                                  <option value="army_officer">Army Officer</option>

                                                  <!-- Others -->
                                                  <option value="consultant">Consultant</option>
                                                  <option value="freelancer">Freelancer</option>
                                                  <option value="intern">Intern</option>
                                                  <option value="trainee">Trainee</option>
                                                  <option value="student">Student</option>
                                                  <option value="self_employed">Self Employed</option>

                                              </select>
                                          </div>
                                      </div>
                                      <div class="form-check auth-policy mt-4">
                                          <input class="form-check-input" type="checkbox" name="policy" value="1"
                                              id="candidatePolicy" required />
                                          <label class="form-check-label" for="candidatePolicy">I agree to the
                                              <a href="#." class="auth-link">Terms of Service</a> and
                                              <a href="#." class="auth-link">Privacy Policy</a>.</label>
                                      </div>
                                      <button type="submit" class="btn btn-primary w-100 mt-4 submitBtn">

                                          <span class="btn-text">Create Candidate Account</span>
                                          <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                      </button>
                                  </form>
                              </div>
                              <div class="tab-pane fade" id="registerEmployer" role="tabpanel"
                                  aria-labelledby="employer-tab">
                                  <form class="auth-form" action="#." method="post">
                                      @csrf
                                      <input type="hidden" name="role" value="employer">
                                      <div class="row g-3">
                                          <div class="col-sm-12">
                                              <label for="companyName" class="form-label">Company name</label>
                                              <input type="text" class="form-control" id="companyName"
                                                  name="company_name" placeholder="Acme Studios" />
                                          </div>
                                          <div class="col-sm-12">
                                              <label for="companyWebsite" class="form-label">Website</label>
                                              <input type="url" class="form-control" id="companyWebsite"
                                                  name="website" placeholder="https://yourcompany.com/" />
                                          </div>
                                          <div class="col-sm-12">
                                              <label for="companyEmail" class="form-label">Work email</label>
                                              <input type="email" class="form-control" id="companyEmail"
                                                  name="email" placeholder="you@company.com" />
                                              <small class="text-danger error-message" data-error="email"></small>
                                          </div>
                                          <div class="col-sm-6">
                                              <label for="employerPassword" class="form-label">Password</label>
                                              <input type="password" class="form-control" id="employerPassword"
                                                  name="password" placeholder="Create a password" />
                                          </div>
                                          <div class="col-sm-6">
                                              <label for="employerTeamSize" class="form-label">Team size</label>
                                              <select class="form-select" id="employerTeamSize" name="team_size">
                                                  <option selected>1-10 employees</option>
                                                  <option>11-50 employees</option>
                                                  <option>51-200 employees</option>
                                                  <option>200+ employees</option>
                                              </select>
                                          </div>
                                      </div>
                                      <div class="form-check auth-policy mt-4">
                                          <input class="form-check-input" type="checkbox" name="policy" value="1"
                                              id="employerPolicy" />
                                          <label class="form-check-label" for="employerPolicy">I accept the
                                              <a href="#." class="auth-link">Terms</a> and confirm I
                                              have hiring authority.</label>
                                      </div>
                                      <button type="submit" class="btn btn-primary w-100 mt-4 submitBtn">
                                          <span class="btn-text">Create Employer Account</span>
                                          <span class="spinner-border spinner-border-sm d-none" role="status"></span>

                                      </button>
                                  </form>
                              </div>
                          </div>
                          <p class="auth-switch">
                              Already have an account? <a href="login.html">Sign in</a>
                          </p>



                      </div>

                      <div id="otpWrapper" class="d-none">
                          <div class="otp-container">
                              <h3>Email Verification</h3>
                              <p class="otp-subtext">
                                  We've sent a 6-digit verification code to your email.
                              </p>

                              <form id="otpForm">
                                  @csrf
                                  <input type="hidden" name="user_id" id="otpUserId">

                                  <div class="otp-inputs">
                                      <input type="text" maxlength="1" class="otp-box" />
                                      <input type="text" maxlength="1" class="otp-box" />
                                      <input type="text" maxlength="1" class="otp-box" />
                                      <input type="text" maxlength="1" class="otp-box" />
                                      <input type="text" maxlength="1" class="otp-box" />
                                      <input type="text" maxlength="1" class="otp-box" />
                                  </div>

                                  <input type="hidden" name="otp" id="finalOtp">

                                  <small class="text-danger error-message" data-error="otp"></small>

                                  <button type="submit" class="btn btn-primary w-100 mt-4 submitBtn">
                                      <span class="btn-text">Verify Code</span>
                                      <span class="spinner-border spinner-border-sm d-none"></span>
                                  </button>
                              </form>

                              <div class="otp-footer">
                                  <span id="resendText">Resend code in <strong id="timer">60</strong>s</span>
                                  <button id="resendBtn" class="btn btn-link d-none">Resend OTP</button>
                              </div>
                          </div>
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

              /* =========================================
                 Spinner Control
              ========================================== */

              function toggleButton(btn, loading = true) {
                  const text = btn.querySelector(".btn-text");
                  const spinner = btn.querySelector(".spinner-border");

                  if (loading) {
                      btn.disabled = true;
                      text.classList.add("d-none");
                      spinner.classList.remove("d-none");
                  } else {
                      btn.disabled = false;
                      text.classList.remove("d-none");
                      spinner.classList.add("d-none");
                  }
              }

              /* =========================================
                 Inline Error Display
              ========================================== */

              function clearErrors(form) {
                  form.querySelectorAll(".error-message").forEach(el => el.innerText = "");
              }

              function showErrors(errors) {
                  Object.keys(errors).forEach(field => {
                      const errorEl = document.querySelector(`[data-error="${field}"]`);
                      if (errorEl) {
                          errorEl.innerText = errors[field][0];
                      }
                  });
              }

              /* =========================================
                 Debounced Email Availability Check
              ========================================== */

              let debounceTimer;


              let emailInput = document.querySelector('[name="email"]');
              let websiteInput = document.querySelector('[name="website"]');
              let roleInput = document.querySelector('[name="role"]');

              let timeout = null;



              /* =========================================
                       Website ↔ Email Validation
                    ========================================== */

              function validateCompanyEmail(form) {
                  const website = form.querySelector('[name="website"]')?.value;
                  const email = form.querySelector('[name="email"]')?.value;

                  if (!website || !email) return true;

                  try {
                      let websiteDomain = new URL(website).hostname.replace("www.", "");
                      let emailDomain = email.split("@")[1];

                      if (!websiteDomain.includes(emailDomain)) {
                          form.querySelector('[data-error="email"]').innerText =
                              "Email must match company website domain.";
                          return false;
                      }

                      return true;

                  } catch (e) {
                      return false;
                  }
              }

              /* =========================================
                 Form Submission
              ========================================== */

              document.querySelectorAll(".auth-form").forEach(form => {

                  form.addEventListener("submit", async function(e) {

                      e.preventDefault();
                      clearErrors(form);

                      if (!validateCompanyEmail(form)) return;

                      const btn = form.querySelector(".submitBtn");
                      toggleButton(btn, true);

                      try {

                          const response = await fetch("/register", {
                              method: "POST",
                              headers: {
                                  "X-CSRF-TOKEN": document
                                      .querySelector('meta[name="csrf-token"]')
                                      .content
                              },
                              body: new FormData(form)
                          });

                          const data = await response.json();

                          if (!response.ok) {
                              throw data;
                          }

                          // SUCCESS
                          showToast(data.message, "success");

                          // Hide entire auth section
                          document.querySelector(".auth-card").classList.add("d-none");

                          // Show OTP Container
                          document.getElementById("otpWrapper").classList.remove("d-none");

                          // Set user id
                          document.getElementById("otpUserId").value = data.user_id;

                          // Start countdown
                          startOtpTimer(60);
                      } catch (err) {

                          toggleButton(btn, false);

                          if (err.errors) {
                              showErrors(err.errors);
                              showToast("Please fix the highlighted errors.", "danger");
                          } else {
                              showToast("Server error. Try again.", "danger");
                          }
                      }

                  });

              });
              /* =========================================
                     OTP Verification
                  ========================================== */

              document.getElementById("otpForm").addEventListener("submit", function(e) {

                  e.preventDefault();

                  let formData = new FormData(this);

                  fetch("/verify-otp", {
                          method: "POST",
                          headers: {
                              "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                          },
                          body: formData
                      })
                      .then(res => res.json())
                      .then(data => {

                          if (data.status) {
                              showToast("Email verified successfully 🎉", "success");
                              //if you want to redirect after verification, you can do it here


                              setTimeout(() => {

                                  if (data.role === "candidate") {
                                      window.location.href = "/candidate/dashboard";
                                  } else {
                                      window.location.href = "/employer/dashboard";
                                  }


                              }, 1500);
                          } else {
                              showToast(data.message, "danger");
                          }

                      })
                      .catch(() => {
                          showToast("Invalid OTP", "danger");
                      });

              });


              //

              // OTP Auto Move
              const otpBoxes = document.querySelectorAll(".otp-box");

              otpBoxes.forEach((box, index) => {

                  box.addEventListener("input", () => {

                      if (box.value.length === 1 && index < otpBoxes.length - 1) {
                          otpBoxes[index + 1].focus();
                      }

                      collectOtp();
                  });

                  box.addEventListener("keydown", (e) => {

                      if (e.key === "Backspace" && !box.value && index > 0) {
                          otpBoxes[index - 1].focus();
                      }
                  });
              });

              // Collect OTP into hidden input
              function collectOtp() {
                  let otp = "";
                  otpBoxes.forEach(box => otp += box.value);
                  document.getElementById("finalOtp").value = otp;

                  if (otp.length === 6) {
                      document.getElementById("otpForm").dispatchEvent(new Event("submit"));
                  }
              }
              //


              function startOtpTimer(seconds) {

                  let timer = seconds;
                  const timerEl = document.getElementById("timer");
                  const resendText = document.getElementById("resendText");
                  const resendBtn = document.getElementById("resendBtn");

                  resendBtn.classList.add("d-none");
                  resendText.classList.remove("d-none");

                  const interval = setInterval(() => {

                      timer--;
                      timerEl.innerText = timer;

                      if (timer <= 0) {
                          clearInterval(interval);
                          resendText.classList.add("d-none");
                          resendBtn.classList.remove("d-none");
                      }

                  }, 1000);
              }

              document.getElementById("resendBtn").addEventListener("click", async function() {

                  const userId = document.getElementById("otpUserId").value;

                  await fetch("/resend-otp", {
                      method: "POST",
                      headers: {
                          "Content-Type": "application/json",
                          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                              .content
                      },
                      body: JSON.stringify({
                          user_id: userId
                      })
                  });

                  showToast("OTP resent successfully", "success");
                  startOtpTimer(60);
              });
          });
      </script>

  @endsection
