@extends('layouts.app')

@section('title', 'Employer Dashboard')

@section('content')

    <div class="employer-hero">
        <div class="container">
            <div class="employer-hero-content">
                <div>
                    <h1>Welcome to Employer Dashboard</h1>
                    <p>Track job postings, packages, and CV views in one place.</p>
                </div>
                <a href="post-job.html" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Post a Job</a>
            </div>
        </div>
    </div>

    <section class="dashboard-section employer-dashboard">
        <div class="container mt-4">
            <div class="dashboard-layout">
                <aside class="dashboard-sidebar employer-sidebar">
                    <div class="sidebar-header">
                        <h2>Northwind Commerce</h2>
                        <p>jobs@northwind.com</p>
                        <span class="company-pill">Premium Employer</span>
                    </div>
                    <ul class="dashboard-nav">
                        <li class="active">
                            <a href="company-dashboard.html"><i class="fa-solid fa-gauge"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="edit-profile.html"><i class="fa-solid fa-user-pen"></i> Edit Account Details</a>
                        </li>
                        <li>
                            <a href="company-detail.html"><i class="fa-solid fa-building"></i> Company Public
                                Profile</a>
                        </li>
                        <li>
                            <a href="post-job.html"><i class="fa-solid fa-plus"></i> Post a Job</a>
                        </li>
                        <li>
                            <a href="job-listing.html"><i class="fa-solid fa-briefcase"></i> Manage Jobs</a>
                        </li>
                        <li>
                            <a href="packages.html"><i class="fa-solid fa-layer-group"></i> CV Search Packages</a>
                        </li>
                        <li>
                            <a href="payment-history.html"><i class="fa-solid fa-credit-card"></i> Payment History</a>
                        </li>
                        <li>
                            <a href="my-messages.html"><i class="fa-solid fa-envelope"></i> Company Messages</a>
                        </li>
                        <li>
                            <a href="my-followings.html"><i class="fa-solid fa-users"></i> Company Followers</a>
                        </li>
                        <li>
                            <a href="#."><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                        </li>
                    </ul>
                </aside>
                <div class="dashboard-main">
                    <div class="row g-3 dashboard-stats">
                        <div class="col-sm-4">
                            <div class="stat-card stat-purple">
                                <span class="stat-icon"><i class="fa-regular fa-clock"></i></span>
                                <div>
                                    <span>Open Jobs</span>
                                    <strong>5</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="stat-card stat-orange">
                                <span class="stat-icon"><i class="fa-solid fa-user-group"></i></span>
                                <div>
                                    <span>Followers</span>
                                    <strong>2</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="stat-card stat-blue">
                                <span class="stat-icon"><i class="fa-regular fa-envelope"></i></span>
                                <div>
                                    <span>Messages</span>
                                    <strong>0</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="employer-panel package-detail-panel">
                        <div class="package-detail-header">
                            <span class="package-header-icon"><i class="fa-solid fa-box-open"></i></span>
                            <h3>Purchased Job Package Details</h3>
                        </div>
                        <div class="package-divider"></div>
                        <div class="package-detail-grid exact">
                            <article class="package-detail-card exact">
                                <span class="detail-icon orange"><i class="fa-solid fa-sun"></i></span>
                                <span class="detail-label">Package Name</span>
                                <strong>Gold</strong>
                            </article>
                            <article class="package-detail-card exact">
                                <span class="detail-icon teal"><i class="fa-solid fa-dollar-sign"></i></span>
                                <span class="detail-label">Price</span>
                                <strong>USD 50</strong>
                            </article>
                            <article class="package-detail-card exact">
                                <span class="detail-icon green"><i class="fa-solid fa-clipboard-check"></i></span>
                                <span class="detail-label">Available Quota</span>
                                <strong class="quota">0 / 24</strong>
                            </article>
                            <article class="package-detail-card exact">
                                <span class="detail-icon blue"><i class="fa-regular fa-calendar"></i></span>
                                <span class="detail-label">Purchased On</span>
                                <strong>2025-04-08<br />11:32:29</strong>
                            </article>
                            <article class="package-detail-card exact">
                                <span class="detail-icon danger"><i class="fa-regular fa-calendar-xmark"></i></span>
                                <span class="detail-label">Package Expires</span>
                                <strong>2026-12-05<br />00:00:00</strong>
                            </article>
                        </div>
                    </section>

                    <section class="employer-panel">
                        <div class="panel-heading">
                            <h3>Upgrade Job Packages</h3>
                            <a href="packages.html">Compare all</a>
                        </div>
                        <div id="" class="plan-grid mt-4">
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
                                        <i class="fa-solid fa-check"></i>Concierge interview
                                        nudges
                                    </li>
                                </ul>
                                <button class="btn btn-outline-success rounded-pill" disabled="">
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
                                    <li>
                                        <i class="fa-solid fa-check"></i>Spotlight placement
                                    </li>
                                    <li><i class="fa-solid fa-check"></i>Invite-only events</li>
                                </ul>
                                <button class="btn btn-outline-primary rounded-pill">
                                    Upgrade to Elite
                                </button>
                            </div>
                        </div>
                    </section>

                    <section class="employer-panel">
                        <div class="panel-heading">
                            <h3>Purchased CVs Package Details</h3>
                            <a href="packages.html">View invoices</a>
                        </div>
                        <div class="package-grid">
                            <div class="package-chip icon purple">
                                <span class="chip-label">Package Name</span>
                                <strong>Startup</strong>
                            </div>
                            <div class="package-chip icon teal">
                                <span class="chip-label">Price</span>
                                <strong>USD 30</strong>
                            </div>
                            <div class="package-chip icon blue">
                                <span class="chip-label">Available CVs</span>
                                <strong>3 / 30</strong>
                            </div>
                            <div class="package-chip icon orange">
                                <span class="chip-label">Purchased On</span>
                                <strong>06 Nov, 2025</strong>
                            </div>
                            <div class="package-chip icon danger">
                                <span class="chip-label">Expires On</span>
                                <strong>06 Dec, 2025</strong>
                            </div>
                        </div>
                    </section>

                    <section class="employer-panel">
                        <div class="panel-heading">
                            <h3>Upgrade CV Search Package</h3>
                        </div>
                        <div id="" class="plan-grid mt-4">
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
                                        <i class="fa-solid fa-check"></i>Concierge interview
                                        nudges
                                    </li>
                                </ul>
                                <button class="btn btn-outline-success rounded-pill" disabled="">
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
                                    <li>
                                        <i class="fa-solid fa-check"></i>Spotlight placement
                                    </li>
                                    <li><i class="fa-solid fa-check"></i>Invite-only events</li>
                                </ul>
                                <button class="btn btn-outline-primary rounded-pill">
                                    Upgrade to Elite
                                </button>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>

@endsection
