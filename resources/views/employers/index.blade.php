@extends('layouts.app')

@section('title', 'Employer Directory')

@section('content')

    <section class="jobs-hero employer-hero">
        <div class="container">
            <div class="jobs-hero-wrapper">
                <span class="jobs-hero-badge">Explore top employers</span>
                <h1 class="jobs-hero-title">
                    Discover companies that match your career goals
                </h1>
                <p class="jobs-hero-copy">
                    Browse verified employers, learn about their culture, and find your
                    next opportunity with companies actively hiring.
                </p>
                <form class="jobs-hero-form">
                    <div class="row g-3">
                        <div class="col-lg-5 col-md-6">
                            <label class="jobs-hero-field">
                                <i class="fa fa-building" aria-hidden="true"></i>
                                <input type="text" class="form-control" placeholder="Company name or keyword" />
                            </label>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="jobs-hero-field select-field">
                                <i class="fa fa-location-dot" aria-hidden="true"></i>
                                <select class="form-select">
                                    <option selected>All locations</option>
                                    <option>Remote</option>
                                    <option>USA - West Coast</option>
                                    <option>Europe</option>
                                    <option>APAC</option>
                                </select>
                            </label>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="jobs-hero-field select-field">
                                <i class="fa fa-industry" aria-hidden="true"></i>
                                <select class="form-select">
                                    <option selected>Industry</option>
                                    <option>Technology</option>
                                    <option>Finance</option>
                                    <option>Healthcare</option>
                                    <option>E-commerce</option>
                                </select>
                            </label>
                        </div>
                        <div class="col-lg-1 col-md-6">
                            <button class="btn btn-primary jobs-hero-submit w-100" type="submit">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="jobs-board employers-board">
        <div class="container">
            <div class="row g-4">
                <aside class="col-lg-3">
                    <div class="filter-card spotlight">
                        <h5>Search companies</h5>
                        <label class="filter-field"><i class="fa fa-building" aria-hidden="true"></i><input type="text"
                                class="form-control" placeholder="Company name" /></label>
                        <label class="filter-field"><i class="fa fa-location-dot" aria-hidden="true"></i><input
                                type="text" class="form-control" placeholder="Location" /></label>
                        <label class="filter-field"><i class="fa fa-industry" aria-hidden="true"></i><input type="text"
                                class="form-control" placeholder="Industry" /></label>
                        <button class="btn btn-primary w-100">Apply filters</button>
                    </div>
                    <div class="filter-card">
                        <h5>Company size</h5>
                        <ul class="filter-list">
                            <li>
                                <label><input type="checkbox" /> 1-50 employees
                                    <span>12</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> 51-200 employees
                                    <span>18</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> 201-1000 employees
                                    <span>15</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> 1000+ employees
                                    <span>9</span></label>
                            </li>
                        </ul>
                    </div>
                    <div class="filter-card">
                        <h5>Open positions</h5>
                        <ul class="filter-list">
                            <li>
                                <label><input type="checkbox" /> 1-5 openings
                                    <span>22</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> 6-15 openings
                                    <span>16</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> 16+ openings
                                    <span>8</span></label>
                            </li>
                        </ul>
                    </div>
                    <div class="filter-card">
                        <h5>Industry</h5>
                        <ul class="filter-list">
                            <li>
                                <label><input type="checkbox" /> Technology <span>24</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Finance <span>12</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Healthcare <span>10</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> E-commerce <span>8</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Consulting <span>6</span></label>
                            </li>
                        </ul>
                    </div>
                    <div class="filter-card">
                        <h5>Work model</h5>
                        <ul class="filter-list">
                            <li>
                                <label><input type="checkbox" /> Remote-first
                                    <span>28</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Hybrid <span>18</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> On-site <span>6</span></label>
                            </li>
                        </ul>
                    </div>
                </aside>
                <div class="col-lg-9">
                    <div class="jobs-board-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <h2>38 Companies Found</h2>
                            <span class="jobs-count">Showing 1 - 12 verified employers</span>
                        </div>
                        <div class="jobs-actions d-flex align-items-center gap-3 flex-wrap">
                            <div class="jobs-view-toggle" role="group" aria-label="Toggle employer view">
                                <a href="employer-grid.html" class="view-btn active" aria-label="Grid view"><i
                                        class="fa fa-th-large" aria-hidden="true"></i></a>
                                <a href="employer-listing.html" class="view-btn" aria-label="List view"><i
                                        class="fa fa-bars" aria-hidden="true"></i></a>
                            </div>
                            <div class="jobs-sort d-flex align-items-center gap-2">
                                <select class="form-select">
                                    <option selected>Most relevant</option>
                                    <option>Most openings</option>
                                    <option>Company size</option>
                                    <option>Recently joined</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 employer-grid">
                        <div class="col-md-6">
                            <div class="employer-card">
                                <div class="employer-card-header">
                                    <div class="employer-logo">
                                        <img src="images/employers/emplogo1.jpg" alt="Skyline Digital" />
                                    </div>
                                    <div class="employer-info">
                                        <span class="employer-badge verified">Verified</span>
                                        <h4><a href="company-detail.html">Skyline Digital</a></h4>
                                        <p>Digital Experience Studio · 180+ employees</p>
                                    </div>
                                    <button class="employer-follow" aria-label="Follow company">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </button>
                                </div>
                                <div class="employer-meta">
                                    <div>
                                        <i class="fa fa-location-dot" aria-hidden="true"></i> San
                                        Francisco, USA
                                    </div>
                                    <div>
                                        <i class="fa fa-briefcase" aria-hidden="true"></i> 8 open
                                        positions
                                    </div>
                                </div>
                                <div class="employer-tags">
                                    <span>Product Design</span><span>Engineering</span><span>Remote-friendly</span>
                                </div>
                                <div class="employer-footer">
                                    <div class="employer-stats">
                                        <span>Founded 2014</span>
                                        <strong>Technology</strong>
                                    </div>
                                    <div class="employer-actions">
                                        <a href="company-detail.html" class="btn btn-outline-primary btn-sm">View
                                            company</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="employer-card">
                                <div class="employer-card-header">
                                    <div class="employer-logo">
                                        <img src="images/employers/emplogo2.jpg" alt="Nexus Finance" />
                                    </div>
                                    <div class="employer-info">
                                        <span class="employer-badge verified">Verified</span>
                                        <h4><a href="company-detail.html">Nexus Finance</a></h4>
                                        <p>Fintech Platform · 250+ employees</p>
                                    </div>
                                    <button class="employer-follow" aria-label="Follow company">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </button>
                                </div>
                                <div class="employer-meta">
                                    <div>
                                        <i class="fa fa-location-dot" aria-hidden="true"></i> New
                                        York, USA
                                    </div>
                                    <div>
                                        <i class="fa fa-briefcase" aria-hidden="true"></i> 12 open
                                        positions
                                    </div>
                                </div>
                                <div class="employer-tags">
                                    <span>Finance</span><span>Banking</span><span>Hybrid</span>
                                </div>
                                <div class="employer-footer">
                                    <div class="employer-stats">
                                        <span>Founded 2016</span>
                                        <strong>Finance</strong>
                                    </div>
                                    <div class="employer-actions">
                                        <a href="company-detail.html" class="btn btn-outline-primary btn-sm">View
                                            company</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="employer-card">
                                <div class="employer-card-header">
                                    <div class="employer-logo">
                                        <img src="images/employers/emplogo3.jpg" alt="HealthTech Solutions" />
                                    </div>
                                    <div class="employer-info">
                                        <span class="employer-badge verified">Verified</span>
                                        <h4>
                                            <a href="company-detail.html">HealthTech Solutions</a>
                                        </h4>
                                        <p>Healthcare Technology · 95+ employees</p>
                                    </div>
                                    <button class="employer-follow" aria-label="Follow company">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </button>
                                </div>
                                <div class="employer-meta">
                                    <div>
                                        <i class="fa fa-location-dot" aria-hidden="true"></i>
                                        Boston, USA
                                    </div>
                                    <div>
                                        <i class="fa fa-briefcase" aria-hidden="true"></i> 6 open
                                        positions
                                    </div>
                                </div>
                                <div class="employer-tags">
                                    <span>Healthcare</span><span>AI/ML</span><span>Remote-first</span>
                                </div>
                                <div class="employer-footer">
                                    <div class="employer-stats">
                                        <span>Founded 2018</span>
                                        <strong>Healthcare</strong>
                                    </div>
                                    <div class="employer-actions">
                                        <a href="company-detail.html" class="btn btn-outline-primary btn-sm">View
                                            company</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="employer-card">
                                <div class="employer-card-header">
                                    <div class="employer-logo">
                                        <img src="images/employers/emplogo4.jpg" alt="CloudCommerce" />
                                    </div>
                                    <div class="employer-info">
                                        <span class="employer-badge verified">Verified</span>
                                        <h4><a href="company-detail.html">CloudCommerce</a></h4>
                                        <p>E-commerce Platform · 320+ employees</p>
                                    </div>
                                    <button class="employer-follow" aria-label="Follow company">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </button>
                                </div>
                                <div class="employer-meta">
                                    <div>
                                        <i class="fa fa-location-dot" aria-hidden="true"></i>
                                        Austin, TX
                                    </div>
                                    <div>
                                        <i class="fa fa-briefcase" aria-hidden="true"></i> 15 open
                                        positions
                                    </div>
                                </div>
                                <div class="employer-tags">
                                    <span>E-commerce</span><span>SaaS</span><span>Hybrid</span>
                                </div>
                                <div class="employer-footer">
                                    <div class="employer-stats">
                                        <span>Founded 2015</span>
                                        <strong>E-commerce</strong>
                                    </div>
                                    <div class="employer-actions">
                                        <a href="company-detail.html" class="btn btn-outline-primary btn-sm">View
                                            company</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="employer-card">
                                <div class="employer-card-header">
                                    <div class="employer-logo">
                                        <img src="images/employers/emplogo5.jpg" alt="DataVault" />
                                    </div>
                                    <div class="employer-info">
                                        <span class="employer-badge verified">Verified</span>
                                        <h4><a href="company-detail.html">DataVault</a></h4>
                                        <p>Data Analytics · 140+ employees</p>
                                    </div>
                                    <button class="employer-follow" aria-label="Follow company">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </button>
                                </div>
                                <div class="employer-meta">
                                    <div>
                                        <i class="fa fa-location-dot" aria-hidden="true"></i>
                                        Seattle, USA
                                    </div>
                                    <div>
                                        <i class="fa fa-briefcase" aria-hidden="true"></i> 9 open
                                        positions
                                    </div>
                                </div>
                                <div class="employer-tags">
                                    <span>Data Science</span><span>Analytics</span><span>Remote-friendly</span>
                                </div>
                                <div class="employer-footer">
                                    <div class="employer-stats">
                                        <span>Founded 2017</span>
                                        <strong>Technology</strong>
                                    </div>
                                    <div class="employer-actions">
                                        <a href="company-detail.html" class="btn btn-outline-primary btn-sm">View
                                            company</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="employer-card">
                                <div class="employer-card-header">
                                    <div class="employer-logo">
                                        <img src="images/employers/emplogo6.jpg" alt="GreenTech Innovations" />
                                    </div>
                                    <div class="employer-info">
                                        <span class="employer-badge verified">Verified</span>
                                        <h4>
                                            <a href="company-detail.html">GreenTech Innovations</a>
                                        </h4>
                                        <p>Sustainability Tech · 75+ employees</p>
                                    </div>
                                    <button class="employer-follow" aria-label="Follow company">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </button>
                                </div>
                                <div class="employer-meta">
                                    <div>
                                        <i class="fa fa-location-dot" aria-hidden="true"></i>
                                        Portland, OR
                                    </div>
                                    <div>
                                        <i class="fa fa-briefcase" aria-hidden="true"></i> 5 open
                                        positions
                                    </div>
                                </div>
                                <div class="employer-tags">
                                    <span>Clean Energy</span><span>IoT</span><span>Hybrid</span>
                                </div>
                                <div class="employer-footer">
                                    <div class="employer-stats">
                                        <span>Founded 2019</span>
                                        <strong>Technology</strong>
                                    </div>
                                    <div class="employer-actions">
                                        <a href="company-detail.html" class="btn btn-outline-primary btn-sm">View
                                            company</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="jobs-pagination mt-4 d-flex flex-wrap align-items-center justify-content-between">
                        <span class="jobs-count">Showing 1 - 12 of 38</span>
                        <ul class="pagination">
                            <li class="active"><a href="#.">1</a></li>
                            <li><a href="#.">2</a></li>
                            <li><a href="#.">3</a></li>
                            <li><a href="#.">Next</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


@section('scripts')



@endsection




