@extends('layouts.app')

@section('title', 'Job Listing')

@section('content')

    <!-- Jobs Hero -->
    <section class="jobs-hero">
        <div class="container">
            <div class="jobs-hero-wrapper">
                <span class="jobs-hero-badge">Browse Opportunities</span>
                <h1 class="jobs-hero-title">
                    Find a role that matches your ambition
                </h1>
                <p class="jobs-hero-copy">
                    Search thousands of curated openings across industries, experience
                    levels, and locations.
                </p>
                <form class="jobs-hero-form">
                    <div class="row g-3">
                        <div class="col-lg-5 col-md-6">
                            <label class="jobs-hero-field">
                                <i class="fa fa-search" aria-hidden="true"></i>
                                <input type="text" class="form-control" placeholder="Job title, keyword or company" />
                            </label>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="jobs-hero-field select-field">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <select class="form-select">
                                    <option selected>Location</option>
                                    <option>Fairbanks</option>
                                    <option>Bessemer</option>
                                    <option>Barrington</option>
                                    <option>Durant</option>
                                </select>
                            </label>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="jobs-hero-field select-field">
                                <i class="fa fa-briefcase" aria-hidden="true"></i>
                                <select class="form-select">
                                    <option selected>Category</option>
                                    <option>Design</option>
                                    <option>Technology</option>
                                    <option>Marketing</option>
                                    <option>Finance</option>
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

    <section class="jobs-board">
        <div class="container">
            <div class="row g-4">
                <aside class="col-lg-3">
                    <div class="filter-card">
                        <h5>Job Type</h5>
                        <ul class="filter-list">
                            <li>
                                <label><input type="checkbox" /> Full Time/Permanent
                                    <span>12</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Contract <span>33</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Part Time <span>18</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Internship <span>11</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Freelance <span>9</span></label>
                            </li>
                        </ul>
                    </div>
                    <div class="filter-card">
                        <h5>Location</h5>
                        <ul class="filter-list">
                            <li>
                                <label><input type="checkbox" /> Fairbanks <span>8</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Bessemer <span>6</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Barrington <span>4</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Durant <span>3</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Blaine <span>2</span></label>
                            </li>
                        </ul>
                    </div>
                    <div class="filter-card">
                        <h5>Industry</h5>
                        <ul class="filter-list">
                            <li>
                                <label><input type="checkbox" /> Information Technology
                                    <span>22</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Advertising/PR
                                    <span>15</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Media &amp; Communications
                                    <span>13</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Fashion <span>9</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Health &amp; Fitness
                                    <span>7</span></label>
                            </li>
                        </ul>
                    </div>
                    <div class="filter-card">
                        <h5>Salary Range</h5>
                        <ul class="filter-list">
                            <li>
                                <label><input type="checkbox" /> $2k - $4k <span>12</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> $4k - $6k <span>9</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> $6k - $10k <span>6</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> $10k - $15k <span>4</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> $15k+ <span>3</span></label>
                            </li>
                        </ul>
                    </div>
                </aside>
                <div class="col-lg-9">
                    <div class="jobs-board-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <h2>18 Jobs Found</h2>
                            <span class="jobs-count">Showing 1 - 18 of 18 results</span>
                        </div>
                        <div class="jobs-actions d-flex align-items-center gap-3 flex-wrap">
                            <div class="jobs-view-toggle" role="group" aria-label="Toggle job view">
                                <a href="job-listing.html" class="view-btn" aria-label="Grid view"><i class="fa fa-th-large"
                                        aria-hidden="true"></i></a>
                                <a href="job-listing.html" class="view-btn active" aria-label="List view"><i
                                        class="fa fa-bars" aria-hidden="true"></i></a>
                            </div>
                            <div class="jobs-sort d-flex align-items-center gap-2">
                                <select class="form-select">
                                    <option selected>Most recent</option>
                                    <option>Salary (High to Low)</option>
                                    <option>Salary (Low to High)</option>
                                    <option>Featured</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="job-list">
                        <div class="job-list-item featured">
                            <div class="job-card-status">
                                <span class="job-type fulltime">Full Time/Permanent</span>
                            </div>
                            <div class="job-list-main">
                                <div class="job-list-logo">
                                    <img src="images/employers/emplogo1.jpg" alt="Multimedia Design" />
                                </div>
                                <div class="job-list-content">
                                    <h4><a href="#.">UI UX Designer Required</a></h4>
                                    <div class="job-list-meta">
                                        <span><i class="fa fa-briefcase" aria-hidden="true"></i>
                                            Multimedia Design</span>
                                        <span><i class="fa fa-map-marker" aria-hidden="true"></i>
                                            Fairbanks</span>
                                        <span><i class="fa fa-money" aria-hidden="true"></i> $2500 -
                                            $3000</span>
                                    </div>
                                    <p class="job-list-summary">
                                        We are seeking a multi-disciplinary designer to ship
                                        intuitive product experiences for our expanding SaaS
                                        platform.
                                    </p>
                                </div>
                                <div class="job-list-actions">
                                    <a href="#." class="btn btn-outline-primary btn-sm">View Details</a>
                                    <button class="bookmark" aria-label="Save job">
                                        <i class="fa-regular fa-bookmark" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="job-list-footer d-flex justify-content-between align-items-center flex-wrap">
                                <span class="job-list-posted">Posted Mar 07, 2025</span>
                                <span class="job-list-posted">ID: JP-2183</span>
                            </div>
                        </div>
                        <div class="job-list-item">
                            <div class="job-card-status">
                                <span class="job-type contract">Contract</span>
                            </div>
                            <div class="job-list-main">
                                <div class="job-list-logo">
                                    <img src="images/employers/emplogo1.jpg" alt="Multimedia Design" />
                                </div>
                                <div class="job-list-content">
                                    <h4><a href="#.">Graphic Designer Required</a></h4>
                                    <div class="job-list-meta">
                                        <span><i class="fa fa-briefcase" aria-hidden="true"></i>
                                            Multimedia Design</span>
                                        <span><i class="fa fa-map-marker" aria-hidden="true"></i>
                                            Bessemer</span>
                                        <span><i class="fa fa-money" aria-hidden="true"></i> $10,000
                                            - $20,000</span>
                                    </div>
                                    <p class="job-list-summary">
                                        Contract opportunity to create compelling digital & print
                                        assets for global brand launches.
                                    </p>
                                </div>
                                <div class="job-list-actions">
                                    <a href="#." class="btn btn-outline-primary btn-sm">View Details</a>
                                    <button class="bookmark" aria-label="Save job">
                                        <i class="fa-regular fa-bookmark" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="job-list-footer d-flex justify-content-between align-items-center flex-wrap">
                                <span class="job-list-posted">Posted Mar 07, 2025</span>
                                <span class="job-list-posted">ID: JP-2184</span>
                            </div>
                        </div>
                        <div class="job-list-item">
                            <div class="job-card-status">
                                <span class="job-type contract">Contract</span>
                            </div>
                            <div class="job-list-main">
                                <div class="job-list-logo">
                                    <img src="images/employers/emplogo1.jpg" alt="Multimedia Design" />
                                </div>
                                <div class="job-list-content">
                                    <h4><a href="#.">Full Stack Developer</a></h4>
                                    <div class="job-list-meta">
                                        <span><i class="fa fa-briefcase" aria-hidden="true"></i>
                                            Multimedia Design</span>
                                        <span><i class="fa fa-map-marker" aria-hidden="true"></i>
                                            Bessemer</span>
                                        <span><i class="fa fa-money" aria-hidden="true"></i> $10,000
                                            - $20,000</span>
                                    </div>
                                    <p class="job-list-summary">
                                        Join our remote engineering pod to build new customer
                                        journeys using React, Node, and GraphQL.
                                    </p>
                                </div>
                                <div class="job-list-actions">
                                    <a href="#." class="btn btn-outline-primary btn-sm">View Details</a>
                                    <button class="bookmark" aria-label="Save job">
                                        <i class="fa-regular fa-bookmark" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="job-list-footer d-flex justify-content-between align-items-center flex-wrap">
                                <span class="job-list-posted">Posted Mar 07, 2025</span>
                                <span class="job-list-posted">ID: JP-2185</span>
                            </div>
                        </div>
                        <div class="job-list-item featured">
                            <div class="job-card-status">
                                <span class="job-type fulltime">Full Time/Permanent</span>
                            </div>
                            <div class="job-list-main">
                                <div class="job-list-logo">
                                    <img src="images/employers/emplogo7.jpg" alt="Connect People" />
                                </div>
                                <div class="job-list-content">
                                    <h4><a href="#.">Full Stack Designer</a></h4>
                                    <div class="job-list-meta">
                                        <span><i class="fa fa-briefcase" aria-hidden="true"></i>
                                            Connect People</span>
                                        <span><i class="fa fa-map-marker" aria-hidden="true"></i>
                                            Barrington</span>
                                        <span><i class="fa fa-money" aria-hidden="true"></i> $6,000 -
                                            $8,000</span>
                                    </div>
                                    <p class="job-list-summary">
                                        Lead design systems that power mobile & web apps for our
                                        fast-growing HR solutions suite.
                                    </p>
                                </div>
                                <div class="job-list-actions">
                                    <a href="#." class="btn btn-outline-primary btn-sm">View Details</a>
                                    <button class="bookmark" aria-label="Save job">
                                        <i class="fa-regular fa-bookmark" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="job-list-footer d-flex justify-content-between align-items-center flex-wrap">
                                <span class="job-list-posted">Posted Mar 07, 2025</span>
                                <span class="job-list-posted">ID: JP-2186</span>
                            </div>
                        </div>
                        <div class="job-list-item">
                            <div class="job-card-status">
                                <span class="job-type contract">Contract</span>
                            </div>
                            <div class="job-list-main">
                                <div class="job-list-logo">
                                    <img src="images/employers/emplogo2.jpg" alt="Power Wave" />
                                </div>
                                <div class="job-list-content">
                                    <h4><a href="#.">Dot Developer</a></h4>
                                    <div class="job-list-meta">
                                        <span><i class="fa fa-briefcase" aria-hidden="true"></i>
                                            Power Wave</span>
                                        <span><i class="fa fa-map-marker" aria-hidden="true"></i>
                                            Durant</span>
                                        <span><i class="fa fa-money" aria-hidden="true"></i> $6,000 -
                                            $12,000</span>
                                    </div>
                                    <p class="job-list-summary">
                                        Modernize enterprise dashboards and microservices in .NET
                                        for a national logistics brand.
                                    </p>
                                </div>
                                <div class="job-list-actions">
                                    <a href="#." class="btn btn-outline-primary btn-sm">View Details</a>
                                    <button class="bookmark" aria-label="Save job">
                                        <i class="fa-regular fa-bookmark" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="job-list-footer d-flex justify-content-between align-items-center flex-wrap">
                                <span class="job-list-posted">Posted Mar 07, 2025</span>
                                <span class="job-list-posted">ID: JP-2187</span>
                            </div>
                        </div>
                        <div class="job-list-item">
                            <div class="job-card-status">
                                <span class="job-type fulltime">Full Time/Permanent</span>
                            </div>
                            <div class="job-list-main">
                                <div class="job-list-logo">
                                    <img src="images/employers/emplogo16.jpg" alt="Mayan Design Studios" />
                                </div>
                                <div class="job-list-content">
                                    <h4><a href="#.">SEO Expert</a></h4>
                                    <div class="job-list-meta">
                                        <span><i class="fa fa-briefcase" aria-hidden="true"></i>
                                            Mayan Design Studios</span>
                                        <span><i class="fa fa-map-marker" aria-hidden="true"></i>
                                            Blaine</span>
                                        <span><i class="fa fa-money" aria-hidden="true"></i> $4,000 -
                                            $8,000</span>
                                    </div>
                                    <p class="job-list-summary">
                                        Drive technical SEO, link-building, and content
                                        experiments for our portfolio of ecommerce brands.
                                    </p>
                                </div>
                                <div class="job-list-actions">
                                    <a href="#." class="btn btn-outline-primary btn-sm">View Details</a>
                                    <button class="bookmark" aria-label="Save job">
                                        <i class="fa-regular fa-bookmark" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="job-list-footer d-flex justify-content-between align-items-center flex-wrap">
                                <span class="job-list-posted">Posted Mar 07, 2025</span>
                                <span class="job-list-posted">ID: JP-2188</span>
                            </div>
                        </div>
                        <div class="job-list-item">
                            <div class="job-card-status">
                                <span class="job-type contract">Contract</span>
                            </div>
                            <div class="job-list-main">
                                <div class="job-list-logo">
                                    <img src="images/employers/emplogo12.jpg" alt="Multimedia Design" />
                                </div>
                                <div class="job-list-content">
                                    <h4><a href="#.">Digital Product Designer</a></h4>
                                    <div class="job-list-meta">
                                        <span><i class="fa fa-briefcase" aria-hidden="true"></i>
                                            Multimedia Design</span>
                                        <span><i class="fa fa-map-marker" aria-hidden="true"></i>
                                            Bessemer</span>
                                        <span><i class="fa fa-money" aria-hidden="true"></i> $6,500 -
                                            $9,000</span>
                                    </div>
                                    <p class="job-list-summary">
                                        Craft high-fidelity prototypes, user flows, and
                                        interaction patterns for fintech experiences.
                                    </p>
                                </div>
                                <div class="job-list-actions">
                                    <a href="#." class="btn btn-outline-primary btn-sm">View Details</a>
                                    <button class="bookmark" aria-label="Save job">
                                        <i class="fa-regular fa-bookmark" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="job-list-footer d-flex justify-content-between align-items-center flex-wrap">
                                <span class="job-list-posted">Posted Mar 07, 2025</span>
                                <span class="job-list-posted">ID: JP-2189</span>
                            </div>
                        </div>
                        <div class="job-list-item">
                            <div class="job-card-status">
                                <span class="job-type fulltime">Full Time/Permanent</span>
                            </div>
                            <div class="job-list-main">
                                <div class="job-list-logo">
                                    <img src="images/employers/emplogo10.jpg" alt="Media Wave" />
                                </div>
                                <div class="job-list-content">
                                    <h4><a href="#.">Marketing Analyst</a></h4>
                                    <div class="job-list-meta">
                                        <span><i class="fa fa-briefcase" aria-hidden="true"></i>
                                            Media Wave</span>
                                        <span><i class="fa fa-map-marker" aria-hidden="true"></i>
                                            Fairbanks</span>
                                        <span><i class="fa fa-money" aria-hidden="true"></i> $5,000 -
                                            $10,000</span>
                                    </div>
                                    <p class="job-list-summary">
                                        Measure campaign performance and build dashboards that
                                        surface high-impact growth insights.
                                    </p>
                                </div>
                                <div class="job-list-actions">
                                    <a href="#." class="btn btn-outline-primary btn-sm">View Details</a>
                                    <button class="bookmark" aria-label="Save job">
                                        <i class="fa-regular fa-bookmark" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="job-list-footer d-flex justify-content-between align-items-center flex-wrap">
                                <span class="job-list-posted">Posted Mar 07, 2025</span>
                                <span class="job-list-posted">ID: JP-2190</span>
                            </div>
                        </div>
                    </div>
                    <div class="jobs-pagination">
                        <nav aria-label="Jobs navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                                <li class="page-item active">
                                    <span class="page-link">1</span>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#.">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#.">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#.">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
