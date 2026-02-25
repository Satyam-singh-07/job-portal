@extends('layouts.app')

@section('title', 'Company Detail')

@section('content')

    <!-- Company Hero -->
    <section class="company-hero">
        <div class="company-hero-cover"
            style="
          background-image: url(&quot;images/employers/cover-photo.jpg&quot;);
        "></div>
        <div class="container">
            <div class="company-hero-wrapper">
                <div class="company-hero-meta">
                    <div class="company-hero-logo">
                        <img src="images/employers/emplogo1.jpg" alt="Skyline Digital" />
                    </div>
                    <div>
                        <span class="company-hero-label">Digital Experience Studio</span>
                        <h1 class="company-hero-title">Skyline Digital</h1>
                        <div class="company-hero-tags">
                            <span><i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                                San Francisco, USA</span>
                            <span><i class="fa-solid fa-users" aria-hidden="true"></i> 180+
                                team members</span>
                            <span><i class="fa-solid fa-calendar-check" aria-hidden="true"></i>
                                Since 2014</span>
                        </div>
                    </div>
                </div>
                <div class="company-hero-actions">
                    <button class="btn btn-outline-primary save-company">
                        <i class="fa-regular fa-bookmark" aria-hidden="true"></i> Follow
                        Company
                    </button>
                    <a href="#openings" class="btn btn-primary"><i class="fa-solid fa-briefcase" aria-hidden="true"></i>
                        View
                        Open Roles</a>
                </div>
            </div>
        </div>
    </section>

    <section class="company-profile">
        <div class="container">
            <div class="row g-4 g-xl-5 align-items-start">
                <div class="col-xl-8 order-2 order-xl-1">
                    <section class="company-detail-section">
                        <h2 class="company-detail-heading">Who We Are</h2>
                        <p>
                            Skyline Digital is a multidisciplinary studio building immersive
                            product experiences for finance, ecommerce, and emerging tech
                            brands. We combine research-led design with battle-tested
                            engineering to launch products that scale across millions of
                            users.
                        </p>
                        <p>
                            Our teams operate with a maker-first culture: weekly design
                            critiques, shared ownership of roadmaps, and space to iterate
                            rapidly so we can keep pushing what digital experiences can be.
                        </p>
                    </section>

                    <section class="company-detail-section">
                        <h3 class="company-detail-heading">What We Value</h3>
                        <div class="company-detail-values">
                            <div class="value-chip">
                                <i class="fa-solid fa-lightbulb"></i> Product Thinking
                            </div>
                            <div class="value-chip">
                                <i class="fa-solid fa-handshake-angle"></i> Transparent
                                Collaboration
                            </div>
                            <div class="value-chip">
                                <i class="fa-solid fa-flask"></i> Experiments Over Ego
                            </div>
                            <div class="value-chip">
                                <i class="fa-solid fa-earth-americas"></i> Global Impact
                            </div>
                            <div class="value-chip">
                                <i class="fa-solid fa-heart"></i> People-First Culture
                            </div>
                        </div>
                    </section>

                    <section class="company-detail-section">
                        <h3 class="company-detail-heading">Life at Skyline</h3>
                        <div class="row g-4 company-perks">
                            <div class="col-sm-6">
                                <div class="perk-card">
                                    <i class="fa-solid fa-plane-departure"></i>
                                    <h4>Remote-Friendly</h4>
                                    <p>
                                        Work where you’re most productive with quarterly in-person
                                        retreats and studio hubs worldwide.
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="perk-card">
                                    <i class="fa-solid fa-graduation-cap"></i>
                                    <h4>Continuous Learning</h4>
                                    <p>
                                        Annual stipend for conferences, certifications, and
                                        mentorship programs led by industry experts.
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="perk-card">
                                    <i class="fa-solid fa-stethoscope"></i>
                                    <h4>Health + Wellness</h4>
                                    <p>
                                        Premium medical cover, wellness allowances, and flexible
                                        time off to recharge and explore.
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="perk-card">
                                    <i class="fa-solid fa-chart-line"></i>
                                    <h4>Growth Mindset</h4>
                                    <p>
                                        Clear leveling frameworks, quarterly career conversations,
                                        and opportunities to switch squads.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="company-detail-section company-detail-gallery">
                        <h3 class="company-detail-heading">Inside Our Studios</h3>
                        <div class="company-detail-subtitle">
                            Take a peek at some of our favourite moments across Skyline hubs
                            and remote retreats.
                        </div>
                        <div class="gallery-grid">
                            <a href="images/gallery/01.jpg" class="gallery-thumb"><img src="images/gallery/01.jpg"
                                    alt="Studio collaboration" /></a>
                            <a href="images/gallery/02.jpg" class="gallery-thumb"><img src="images/gallery/02.jpg"
                                    alt="Team offsite" /></a>
                            <a href="images/gallery/03.html" class="gallery-thumb"><img src="images/gallery/03.html"
                                    alt="Design workshop" /></a>
                            <a href="images/gallery/04.html" class="gallery-thumb"><img src="images/gallery/04.html"
                                    alt="Prototype review" /></a>
                        </div>
                    </section>
                </div>

                <div class="col-xl-4 order-1 order-xl-2">
                    <aside class="company-sidebar">
                        <div class="company-side-card">
                            <h3>Company Snapshot</h3>
                            <dl class="company-facts">
                                <div class="fact-item">
                                    <dt><i class="fa-solid fa-globe"></i> Website</dt>
                                    <dd>
                                        <a href="https://www.skylinedigital.com/">skylinedigital.com</a>
                                    </dd>
                                </div>
                                <div class="fact-item">
                                    <dt><i class="fa-solid fa-industry"></i> Industry</dt>
                                    <dd>Product Design &amp; Engineering</dd>
                                </div>
                                <div class="fact-item">
                                    <dt><i class="fa-solid fa-layer-group"></i> Departments</dt>
                                    <dd>Design, Engineering, Research</dd>
                                </div>
                                <div class="fact-item">
                                    <dt><i class="fa-solid fa-map-pin"></i> Offices</dt>
                                    <dd>SF · Berlin · Singapore · Remote</dd>
                                </div>
                                <div class="fact-item">
                                    <dt><i class="fa-solid fa-chart-simple"></i> Growth</dt>
                                    <dd>45% YoY revenue</dd>
                                </div>
                            </dl>
                            <div class="company-social">
                                <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                                <a href="#" aria-label="Dribbble"><i class="fa-brands fa-dribbble"></i></a>
                                <a href="#" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                                <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                            </div>
                        </div>

                        <div class="company-side-card">
                            <h3>Get In Touch</h3>
                            <form class="company-contact-form" action="#." method="post">
                                <div class="mb-3">
                                    <label class="form-label" for="companyContactName">Full name</label>
                                    <input type="text" class="form-control" id="companyContactName"
                                        placeholder="Jordan Blake" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="companyContactEmail">Work email</label>
                                    <input type="email" class="form-control" id="companyContactEmail"
                                        placeholder="you@company.com" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="companyContactMessage">Message</label>
                                    <textarea class="form-control" id="companyContactMessage" rows="4"
                                        placeholder="Tell us how we can collaborate…"></textarea>
                                </div>
                                <button type="submit" class="btn btn-outline-primary w-100">
                                    Send Message
                                </button>
                            </form>
                        </div>

                        <div class="company-side-card map-card">
                            <h3>Studio Locations</h3>
                            <div class="ratio ratio-4x3">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d193572.19492844533!2d-74.11808565615137!3d40.70556503857166!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2s!4v1481975053066"
                                    allowfullscreen></iframe>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

    <section id="openings" class="company-openings-section">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                <div>
                    <h2 class="company-detail-heading mb-1">Open Roles</h2>
                    <p class="company-detail-subtitle mb-0">
                        We’re hiring across design, engineering, and strategy. Join our
                        fully distributed team.
                    </p>
                </div>
                <a href="#." class="btn btn-outline-primary"><i class="fa-solid fa-envelope"></i> Refer a Friend</a>
            </div>
            <div class="row g-4 job-grid">
                <div class="col-md-6 col-xl-4">
                    <div class="job-board-card">
                        <div class="job-card-status">
                            <span class="job-type fulltime">Full Time</span>
                        </div>
                        <h4><a href="job-detail.html">Lead Product Designer</a></h4>
                        <div class="job-salary">
                            Salary: <strong>$120k - $150k</strong>
                        </div>
                        <div class="job-location">
                            <i class="fa-solid fa-location-dot"></i> Remote · North America
                        </div>
                        <div class="job-card-footer">
                            <div class="job-card-company">
                                <img src="images/employers/emplogo1.jpg" alt="Skyline Digital" />
                                <div>
                                    <span class="label">Posted</span>
                                    <span class="value">3 days ago</span>
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
                        <h4><a href="job-detail.html">Senior Frontend Engineer</a></h4>
                        <div class="job-salary">
                            Salary: <strong>€85k - €110k</strong>
                        </div>
                        <div class="job-location">
                            <i class="fa-solid fa-location-dot"></i> Berlin, Germany
                        </div>
                        <div class="job-card-footer">
                            <div class="job-card-company">
                                <img src="images/employers/emplogo7.jpg" alt="Skyline Digital" />
                                <div>
                                    <span class="label">Posted</span>
                                    <span class="value">1 week ago</span>
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
                        <h4><a href="job-detail.html">Platform Delivery Manager</a></h4>
                        <div class="job-salary">
                            Salary: <strong>$95k - $135k</strong>
                        </div>
                        <div class="job-location">
                            <i class="fa-solid fa-location-dot"></i> Singapore
                        </div>
                        <div class="job-card-footer">
                            <div class="job-card-company">
                                <img src="images/employers/emplogo10.jpg" alt="Skyline Digital" />
                                <div>
                                    <span class="label">Posted</span>
                                    <span class="value">2 weeks ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
