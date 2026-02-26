@extends('layouts.app')

@section('title', 'Candidate Dashboard')

@section('content')

    <section class="dashboard-section">
        <div class="container">
            <div class="dashboard-layout">

                @include('candidates.partials.sidebar')

                <div class="dashboard-main">
                    <div class="row g-3 dashboard-stats">
                        <div class="col-6 col-md-3">
                            <div class="stat-card stat-purple">
                                <span>Profile Views</span>
                                <strong>219</strong>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card stat-orange">
                                <span>Followings</span>
                                <strong>4</strong>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card stat-blue">
                                <span>My CV List</span>
                                <strong>1</strong>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card stat-teal">
                                <span>Messages</span>
                                <strong>0</strong>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-cover-card">
                        <div class="dashboard-cover-media">
                            <img src="{{ asset('images/user-cover.html') }}" alt="Workspace collaboration" />
                        </div>
                        <div class="dashboard-cover-profile">
                            <div class="cover-avatar">
                                <img src="{{ asset('images/candidates/01.jpg') }}" alt="Job Seeker" />
                            </div>
                            <div>
                                <h3>Job Seeker</h3>
                                <p>Bainbridge Island, Washington, United States of America</p>
                                <ul>
                                    <li><i class="fa-solid fa-phone"></i> +1 234 567 890</li>
                                    <li>
                                        <i class="fa-solid fa-envelope"></i> seeker@jobsportal.com
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <section class="dashboard-panel">
                        <div class="panel-heading">
                            <h3>My Applied Jobs</h3>
                            <a href="#.">View All</a>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="applied-card">
                                    <span class="badge-status">Full Time</span>
                                    <h4>Project Manager</h4>
                                    <p>Kaneboe Station</p>
                                    <div class="applied-meta">
                                        <span>Salary: USD5000 - USD6000/Monthly</span>
                                        <span>Applied: Oct 31, 2025</span>
                                    </div>
                                    <div class="applied-footer">
                                        <div>
                                            <strong>Multimedia Design</strong>
                                        </div>
                                        <img src="{{ asset('images/employers/emplogo5.jpg') }}" alt="Multimedia Design" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="applied-card">
                                    <span class="badge-status">Full Time</span>
                                    <h4>Full Stack Designer</h4>
                                    <p>Barrington</p>
                                    <div class="applied-meta">
                                        <span>Salary: USD6000 - USD8000/Monthly</span>
                                        <span>Applied: Oct 29, 2025</span>
                                    </div>
                                    <div class="applied-footer">
                                        <div>
                                            <strong>Connect People</strong>
                                        </div>
                                        <img src="{{ asset('images/employers/emplogo7.jpg') }}" alt="Connect People" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="applied-card">
                                    <span class="badge-status danger">Contract</span>
                                    <h4>Full Stack Developer</h4>
                                    <p>Bessemer</p>
                                    <div class="applied-meta">
                                        <span>Salary: USD10000 - USD20000/Monthly</span>
                                        <span>Applied: Oct 25, 2025</span>
                                    </div>
                                    <div class="applied-footer">
                                        <div>
                                            <strong>Multimedia Design</strong>
                                        </div>
                                        <img src="{{ asset('images/employers/emplogo1.jpg') }}" alt="Multimedia Design" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="dashboard-panel">
                        <div class="panel-heading">
                            <h3>Active Package Details</h3>
                        </div>
                        <div class="package-grid">
                            <div class="package-chip">
                                <span class="label">Package Name</span>
                                <strong>Basic Jobs View</strong>
                            </div>
                            <div class="package-chip">
                                <span class="label">Price</span>
                                <strong>USD 10</strong>
                            </div>
                            <div class="package-chip">
                                <span class="label">Applications</span>
                                <strong>02 / 20</strong>
                            </div>
                            <div class="package-chip">
                                <span class="label">Started On</span>
                                <strong>N/A</strong>
                            </div>
                            <div class="package-chip danger">
                                <span class="label">Expires On</span>
                                <strong>31 Dec, 2025</strong>
                            </div>
                        </div>
                    </section>

                    <section class="dashboard-panel">
                        <div class="panel-heading">
                            <h3>Recommended Jobs</h3>
                            <a href="#.">View All</a>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="recommended-card">
                                    <span class="badge-status">Full Time</span>
                                    <h4>UI/UX Designer</h4>
                                    <p>Islamabad · Power Color</p>
                                    <div class="recommended-meta">
                                        <span>Salary: $6000 - $9000/Monthly</span>
                                        <span>Mar 07, 2025</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="recommended-card">
                                    <span class="badge-status">Full Time</span>
                                    <h4>iOS Developer</h4>
                                    <p>Atlanta · Multimedia Design</p>
                                    <div class="recommended-meta">
                                        <span>Salary: $6000 - $9000/Monthly</span>
                                        <span>Mar 07, 2025</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="recommended-card">
                                    <span class="badge-status danger">Contract</span>
                                    <h4>Electrical Engineer</h4>
                                    <p>Denver · Power Wave</p>
                                    <div class="recommended-meta">
                                        <span>Salary: $5000 - $9000/Monthly</span>
                                        <span>Mar 07, 2025</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="dashboard-panel">
                        <div class="panel-heading">
                            <h3>My Followings</h3>
                            <a href="#.">View All</a>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="following-card">
                                    <h4>Web Design Studio</h4>
                                    <p>Information Technology<br />Your Location Address USA</p>
                                    <span>8 Open Jobs</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="following-card">
                                    <h4>Multimedia Design</h4>
                                    <p>Manufacturing<br />Your Location Address USA</p>
                                    <span>5 Open Jobs</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="following-card">
                                    <h4>Connect People</h4>
                                    <p>Technology Services<br />Your Location Address USA</p>
                                    <span>5 Open Jobs</span>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </section>

@endsection
