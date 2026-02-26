 @extends('layouts.app')

@section('title', 'Job Alerts')

@section('content')

 <section class="dashboard-section">
      <div class="container">
        <div class="dashboard-layout">
         
                @include('candidates.partials.sidebar')
          <div class="dashboard-main">
            <div class="dashboard-page-header">
              <div>
                <h1>Candidate Packages</h1>
                <p>
                  Unlock more visibility, AI tools, and concierge support with
                  the plan that fits your search.
                </p>
              </div>
              <div class="d-flex flex-wrap gap-2">
                <a href="payment-history.html" class="btn btn-outline-primary"
                  ><i class="fa-solid fa-receipt" aria-hidden="true"></i>
                  Billing</a
                >
                <a href="#upgrade" class="btn btn-primary"
                  ><i
                    class="fa-solid fa-arrow-up-right-dots"
                    aria-hidden="true"
                  ></i>
                  Upgrade</a
                >
              </div>
            </div>

            <div class="current-plan-card">
              <div class="current-plan-meta">
                <div class="plan-icon primary">
                  <i class="fa-solid fa-certificate" aria-hidden="true"></i>
                </div>
                <div>
                  <span class="plan-badge">Current Plan</span>
                  <h3>Pro Candidate</h3>
                  <p>Expires on 31 Dec 2025 · Auto-renew enabled.</p>
                </div>
              </div>
              <div class="current-plan-price">
                <span class="currency">USD</span>
                <strong>29</strong>
                <span class="term">/ month</span>
              </div>
            </div>
            <div class="plan-metrics">
              <div class="metric-pill">
                <div class="metric-icon primary">
                  <i class="fa-solid fa-briefcase" aria-hidden="true"></i>
                </div>
                <div>
                  <span>Applications</span>
                  <strong>20 / 40 used</strong>
                </div>
              </div>
              <div class="metric-pill">
                <div class="metric-icon">
                  <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
                </div>
                <div>
                  <span>Resume scans</span>
                  <strong>6 / 10 remaining</strong>
                </div>
              </div>
              <div class="metric-pill">
                <div class="metric-icon highlight">
                  <i class="fa-solid fa-headset" aria-hidden="true"></i>
                </div>
                <div>
                  <span>Concierge credits</span>
                  <strong>2 scheduled</strong>
                </div>
              </div>
              <div class="metric-pill">
                <div class="metric-icon success">
                  <i
                    class="fa-solid fa-wand-magic-sparkles"
                    aria-hidden="true"
                  ></i>
                </div>
                <div>
                  <span>AI rewrites</span>
                  <strong>Unlimited</strong>
                </div>
              </div>
            </div>

            <div id="upgrade" class="plan-grid mt-4">
              <div class="plan-card">
                <div class="plan-icon">
                  <i class="fa-solid fa-seedling" aria-hidden="true"></i>
                </div>
                <h4>Starter</h4>
                <div class="plan-price">
                  <span>$</span>15<small>/month</small>
                </div>
                <ul class="plan-list">
                  <li>
                    <i class="fa-solid fa-check"></i>10 applications / month
                  </li>
                  <li><i class="fa-solid fa-check"></i>2 resume scans</li>
                  <li><i class="fa-solid fa-check"></i>Email support</li>
                  <li><i class="fa-solid fa-check"></i>Basic analytics</li>
                </ul>
                <button class="btn btn-outline-primary rounded-pill">
                  Downgrade to Starter
                </button>
              </div>
              <div class="plan-card active">
                <div class="plan-icon primary">
                  <i class="fa-solid fa-gem" aria-hidden="true"></i>
                </div>
                <h4>Pro (Current)</h4>
                <div class="plan-price">
                  <span>$</span>29<small>/month</small>
                </div>
                <ul class="plan-list">
                  <li><i class="fa-solid fa-check"></i>40 applications</li>
                  <li><i class="fa-solid fa-check"></i>10 resume scans</li>
                  <li>
                    <i class="fa-solid fa-check"></i>AI rewrites + recruiter
                    boost
                  </li>
                  <li>
                    <i class="fa-solid fa-check"></i>Concierge interview nudges
                  </li>
                </ul>
                <button class="btn btn-outline-success rounded-pill" disabled>
                  Current plan
                </button>
              </div>
              <div class="plan-card">
                <div class="plan-icon highlight">
                  <i class="fa-solid fa-crown" aria-hidden="true"></i>
                </div>
                <h4>Elite</h4>
                <div class="plan-price">
                  <span>$</span>79<small>/month</small>
                </div>
                <ul class="plan-list">
                  <li>
                    <i class="fa-solid fa-check"></i>Unlimited applications
                  </li>
                  <li>
                    <i class="fa-solid fa-check"></i>Concierge career coach
                  </li>
                  <li><i class="fa-solid fa-check"></i>Spotlight placement</li>
                  <li><i class="fa-solid fa-check"></i>Invite-only events</li>
                </ul>
                <button class="btn btn-outline-primary rounded-pill">
                  Upgrade to Elite
                </button>
              </div>
            </div>

            <div class="list-card mt-4">
              <h3>Recent Activity</h3>
              <ul>
                <li>
                  <div>
                    <strong>Concierge review booked</strong>
                    <p class="mb-0 text-muted">
                      Career coach session scheduled for Apr 25 at 10:30am.
                    </p>
                  </div>
                  <span>Credit -1</span>
                </li>
                <li>
                  <div>
                    <strong>Plan renewed</strong>
                    <p class="mb-0 text-muted">
                      Auto-renew processed on Mar 31 · Invoice #INV-2048.
                    </p>
                  </div>
                  <a
                    href="payment-history.html"
                    class="btn btn-outline-primary btn-sm rounded-3"
                    >View receipt</a
                  >
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>


@endsection