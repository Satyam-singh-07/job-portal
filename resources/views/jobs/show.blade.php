@extends('layouts.app')

@section('title', 'Job Detail')

@section('content')

    <!-- Job Detail Hero -->
    <section class="job-detail-hero">
        <div class="container">
            <div class="job-detail-header">
                <div class="job-detail-company">
                    <div class="job-detail-logo">
                        <img src="images/employers/emplogo1.jpg" alt="Forum International" />
                    </div>
                    <div>
                        <span class="job-detail-label">Product &amp; Engineering</span>
                        <h1 class="job-detail-title">
                            IT Delivery Manager &mdash; Epicor ERP
                        </h1>
                        <div class="job-detail-tags">
                            <span><i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                                Dubai, UAE</span>
                            <span><i class="fa-solid fa-briefcase" aria-hidden="true"></i> Full
                                Time · Hybrid</span>
                            <span><i class="fa-solid fa-money-bill-wave" aria-hidden="true"></i>
                                $500 - $3000 / month</span>
                        </div>
                    </div>
                </div>
                <div class="job-detail-actions">
                    <a href="#." class="btn btn-primary"><i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                        Apply
                        Now</a>
                    <button class="btn btn-outline-primary job-save">
                        <i class="fa-regular fa-bookmark" aria-hidden="true"></i> Save Job
                    </button>
                    <button class="btn btn-link job-share">
                        <i class="fa-solid fa-share-nodes" aria-hidden="true"></i> Share
                    </button>
                </div>
            </div>
            <div class="job-detail-meta">
                <div class="meta-item">
                    <i class="fa-solid fa-calendar" aria-hidden="true"></i>
                    <div>
                        <span class="label">Posted On</span>
                        <span class="value">May 19, 2025</span>
                    </div>
                </div>
                <div class="meta-item">
                    <i class="fa-solid fa-user-tie" aria-hidden="true"></i>
                    <div>
                        <span class="label">Seniority</span>
                        <span class="value">Lead / Manager</span>
                    </div>
                </div>
                <div class="meta-item">
                    <i class="fa-solid fa-building" aria-hidden="true"></i>
                    <div>
                        <span class="label">Company</span>
                        <span class="value">Forum International</span>
                    </div>
                </div>
                <div class="meta-item">
                    <i class="fa-solid fa-clock" aria-hidden="true"></i>
                    <div>
                        <span class="label">Working Time</span>
                        <span class="value">Monday - Friday · 9am-5pm</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="job-detail-body">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <article class="job-content-card">
                        <h2>Role Overview</h2>
                        <p>
                            We are looking for a strategic delivery manager who can lead
                            cross-functional teams to ship Epicor ERP initiatives on
                            schedule. You will coordinate the full lifecycle from discovery
                            to go-live and ensure stakeholders are aligned every step of the
                            way.
                        </p>
                        <p>
                            Working closely with engineering, product, and operations, you
                            will design scalable processes, build dashboards that surface
                            health metrics, and remove blockers so teams can focus on
                            creating value for thousands of global users.
                        </p>
                    </article>

                    <article class="job-content-card">
                        <h3>What You'll Do</h3>
                        <ul class="job-bullet-list">
                            <li>
                                Own the roadmap for Epicor ERP releases, aligning plans with
                                business OKRs and financial goals.
                            </li>
                            <li>
                                Mentor scrum leads and coordinate delivery ceremonies, sprint
                                planning, and retrospectives.
                            </li>
                            <li>
                                Partner with security and infrastructure teams to maintain
                                compliance and high availability SLAs.
                            </li>
                            <li>
                                Present delivery status, risk assessments, and mitigation
                                plans to executive stakeholders.
                            </li>
                            <li>
                                Continuously refine workflows by analyzing cycle times,
                                throughput, and quality signals.
                            </li>
                        </ul>
                    </article>

                    <article class="job-content-card">
                        <h3>Skills &amp; Experience</h3>
                        <ul class="job-bullet-list">
                            <li>
                                5+ years leading enterprise software implementations or
                                technical program management.
                            </li>
                            <li>
                                Hands-on experience with Epicor ERP (or similar platforms)
                                across manufacturing workflows.
                            </li>
                            <li>
                                Working knowledge of Agile practices, modern DevOps tooling,
                                and cloud infrastructure.
                            </li>
                            <li>
                                Comfort presenting to senior leadership and aligning teams
                                across time zones.
                            </li>
                            <li>
                                Strong communication, stakeholder management, and change
                                enablement skills.
                            </li>
                        </ul>
                    </article>

                    <article class="job-content-card">
                        <h3>Benefits &amp; Perks</h3>
                        <div class="job-tag-cloud">
                            <span>Annual bonus</span>
                            <span>Hybrid work flexibility</span>
                            <span>Private medical cover</span>
                            <span>Learning stipend</span>
                            <span>Wellness allowance</span>
                            <span>Visa sponsorship</span>
                        </div>
                    </article>

                    <article class="job-content-card">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <h3>How to Apply</h3>
                                <p class="mb-0">
                                    Attach your updated resume, share 2-3 project highlights,
                                    and tell us how you improved delivery velocity in your
                                    previous role.
                                </p>
                            </div>
                            <a href="#." class="btn btn-primary"><i class="fa-solid fa-cloud-upload"
                                    aria-hidden="true"></i>
                                Submit Application</a>
                        </div>
                    </article>
                </div>

                <div class="col-lg-4">
                    <aside class="job-sidebar">
                        <div class="job-side-card">
                            <h3>Job Snapshot</h3>
                            <ul class="job-snapshot">
                                <li>
                                    <i class="fa-solid fa-hashtag" aria-hidden="true"></i><span>Job
                                        ID</span><strong>JB132456</strong>
                                </li>
                                <li>
                                    <i class="fa-solid fa-map-pin"
                                        aria-hidden="true"></i><span>Location</span><strong>Dubai, United Arab
                                        Emirates</strong>
                                </li>
                                <li>
                                    <i class="fa-solid fa-people-group" aria-hidden="true"></i><span>Team
                                        Size</span><strong>25+ collaborators</strong>
                                </li>
                                <li>
                                    <i class="fa-solid fa-sack-dollar"
                                        aria-hidden="true"></i><span>Compensation</span><strong>$500 - $3000</strong>
                                </li>
                                <li>
                                    <i class="fa-solid fa-briefcase"
                                        aria-hidden="true"></i><span>Employment</span><strong>Full-time · Hybrid</strong>
                                </li>
                                <li>
                                    <i class="fa-solid fa-graduation-cap"
                                        aria-hidden="true"></i><span>Education</span><strong>Master’s preferred</strong>
                                </li>
                            </ul>
                        </div>

                        <div class="job-side-card">
                            <h3>Talk to Forum International</h3>
                            <form class="job-contact-form" action="#." method="post">
                                <div class="mb-3">
                                    <label class="form-label" for="contactName">Full name</label>
                                    <input type="text" class="form-control" id="contactName" placeholder="Alex Morgan" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="contactEmail">Email address</label>
                                    <input type="email" class="form-control" id="contactEmail"
                                        placeholder="you@email.com" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="contactMessage">Message</label>
                                    <textarea class="form-control" id="contactMessage" rows="4" placeholder="Share a short note…"></textarea>
                                </div>
                                <button type="submit" class="btn btn-outline-primary w-100">
                                    Send Message
                                </button>
                            </form>
                        </div>

                        <div class="job-side-card map-card">
                            <h3>Office Location</h3>
                            <div class="ratio ratio-4x3">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d13276.272465119835!2d72.97962462269287!3d33.70718629417979!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2s!4v1480401216309"
                                    allowfullscreen></iframe>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

    <section class="job-related">
        <div class="container">
            <div class="titleTop text-center">
                <div class="subtitle">Explore More Roles</div>
                <h3>Related Opportunities</h3>
            </div>
            <div class="row g-4 job-grid">
                <div class="col-md-6 col-xl-4">
                    <div class="job-board-card">
                        <div class="job-card-status">
                            <span class="job-type fulltime">Full Time</span>
                        </div>
                        <h4><a href="#.">Product Delivery Lead</a></h4>
                        <div class="job-salary">
                            Salary: <strong>$6,000 - $9,500</strong>
                        </div>
                        <div class="job-location">
                            <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                            Doha, Qatar
                        </div>
                        <div class="job-card-footer">
                            <div class="job-card-company">
                                <img src="images/employers/emplogo2.jpg" alt="Power Wave" />
                                <div>
                                    <span class="label">Posted</span>
                                    <span class="value">May 11, 2025</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="job-board-card featured">
                        <div class="job-card-status">
                            <span class="job-type fulltime">Full Time</span>
                        </div>
                        <h4><a href="#.">ERP Transformation Manager</a></h4>
                        <div class="job-salary">
                            Salary: <strong>$7,500 - $11,000</strong>
                        </div>
                        <div class="job-location">
                            <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                            Riyadh, Saudi Arabia
                        </div>
                        <div class="job-card-footer">
                            <div class="job-card-company">
                                <img src="images/employers/emplogo7.jpg" alt="Connect People" />
                                <div>
                                    <span class="label">Posted</span>
                                    <span class="value">May 05, 2025</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="job-board-card">
                        <div class="job-card-status">
                            <span class="job-type contract">Contract</span>
                        </div>
                        <h4><a href="#.">Technical Program Manager</a></h4>
                        <div class="job-salary">
                            Salary: <strong>$4,800 - $7,200</strong>
                        </div>
                        <div class="job-location">
                            <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                            Remote, EMEA
                        </div>
                        <div class="job-card-footer">
                            <div class="job-card-company">
                                <img src="images/employers/emplogo10.jpg" alt="Media Wave" />
                                <div>
                                    <span class="label">Posted</span>
                                    <span class="value">Apr 28, 2025</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
