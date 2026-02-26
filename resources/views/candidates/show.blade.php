@extends('layouts.app')

@section('title', 'Candidate Detail')

@section('content')

    <section class="candidate-hero">
        <div class="candidate-hero-cover">
            <img src="{{ asset('images/employers/cover-photo.jpg') }}" alt="Cover Photo" class="w-100 cover-img">
        </div>
        <div class="container">
            <div class="candidate-hero-wrapper">
                <div class="candidate-avatar-lg">
                    <img src="{{ asset('images/candidates/01.jpg') }}" alt="Elliot Scott" />
                </div>
                <div class="candidate-hero-body">
                    <span class="candidate-pill">Open to fractional / remote roles</span>
                    <div class="candidate-hero-header">
                        <div>
                            <h1>Elliot Scott</h1>
                            <p>Lead Product Designer · Currently at Northwind Commerce</p>
                        </div>
                        <button class="candidate-save-btn" aria-label="Save candidate">
                            <i class="fa-regular fa-bookmark"></i>
                        </button>
                    </div>
                    <ul class="candidate-hero-meta">
                        <li>
                            <i class="fa fa-map-marker" aria-hidden="true"></i> Seattle, USA
                            · Remote friendly
                        </li>
                        <li>
                            <i class="fa fa-briefcase" aria-hidden="true"></i> 9 yrs
                            experience
                        </li>
                        <li>
                            <i class="fa fa-language" aria-hidden="true"></i> English,
                            Spanish
                        </li>
                    </ul>
                    <div class="candidate-hero-tags">
                        <span>Fintech</span><span>Design Ops</span><span>Enterprise SaaS</span><span>Leadership</span>
                    </div>
                </div>
                <div class="candidate-hero-actions">
                    <a href="#contact" class="btn btn-primary btn-lg"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                        Request
                        intro</a>
                    <a href="#portfolio" class="btn btn-outline-primary btn-lg"><i class="fa fa-download"
                            aria-hidden="true"></i> Download CV</a>
                </div>
            </div>
        </div>
    </section>

    <section class="candidate-profile">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="candidate-section">
                        <div class="section-head">
                            <h3>About Elliot</h3>
                            <span>Blending design systems with storytelling</span>
                        </div>
                        <p>
                            Elliot is a product design lead focused on building commerce
                            experiences that scale across markets. He has led
                            interdisciplinary pods of researchers, PMs, and engineers to
                            ship onboarding flows, marketplace redesigns, and design system
                            overhauls for companies like Northwind, Tailspin, and Fabrikam.
                        </p>
                        <div class="candidate-highlights">
                            <div>
                                <h4>$28M</h4>
                                <p>Incremental revenue unlocked via checkout redesign</p>
                            </div>
                            <div>
                                <h4>+32%</h4>
                                <p>Increase in activation after introducing guided setup</p>
                            </div>
                            <div>
                                <h4>4 countries</h4>
                                <p>Launched localized experiences with on-site research</p>
                            </div>
                        </div>
                    </div>

                    <div class="candidate-section">
                        <div class="section-head">
                            <h3>Experience</h3>
                            <span>Roles & impact</span>
                        </div>
                        <div class="experience-timeline">
                            <article class="timeline-node">
                                <span class="timeline-marker"></span>
                                <div class="timeline-content">
                                    <h4>UI UX Designer</h4>
                                    <div class="timeline-meta">
                                        <span><i class="fa-solid fa-location-dot" aria-hidden="true"></i>Lahore ·
                                            Pakistan</span>
                                        <span><i class="fa-solid fa-building" aria-hidden="true"></i>Amoka Int</span>
                                        <span><i class="fa-regular fa-calendar" aria-hidden="true"></i>13 Dec, 2009 – 07
                                            Feb, 2012</span>
                                    </div>
                                    <p>
                                        Proactive and disciplined, leading accessibility
                                        initiatives and elevating customer experiences across the
                                        entire design process.
                                    </p>
                                </div>
                            </article>
                            <article class="timeline-node">
                                <span class="timeline-marker"></span>
                                <div class="timeline-content">
                                    <h4>Graphic Designer</h4>
                                    <div class="timeline-meta">
                                        <span><i class="fa-solid fa-location-dot" aria-hidden="true"></i>Liège ·
                                            Belgium</span>
                                        <span><i class="fa-solid fa-building" aria-hidden="true"></i>Multimedia
                                            Design</span>
                                        <span><i class="fa-regular fa-calendar" aria-hidden="true"></i>09 Jul, 2025 – 19
                                            Nov, 2025</span>
                                    </div>
                                    <p>
                                        Partnered with product and engineering to craft
                                        user-centric marketing assets and campaign microsites for
                                        European launches.
                                    </p>
                                </div>
                            </article>
                            <article class="timeline-node">
                                <span class="timeline-marker"></span>
                                <div class="timeline-content">
                                    <h4>Lead Product Designer</h4>
                                    <div class="timeline-meta">
                                        <span><i class="fa-solid fa-location-dot" aria-hidden="true"></i>Remote · US &
                                            EU</span>
                                        <span><i class="fa-solid fa-building" aria-hidden="true"></i>Northwind
                                            Commerce</span>
                                        <span><i class="fa-regular fa-calendar" aria-hidden="true"></i>2021 – Present</span>
                                    </div>
                                    <p>
                                        Guiding multi-disciplinary pods to ship merchant
                                        onboarding, design systems, and AI-powered tooling for 85K
                                        SMB customers.
                                    </p>
                                </div>
                            </article>
                        </div>
                    </div>

                    <div class="candidate-section">
                        <div class="section-head">
                            <h3>Skills & tools</h3>
                            <span>Technical + human skills</span>
                        </div>
                        <div class="skill-chip-grid">
                            <span>Design Systems</span><span>Service Design</span><span>User Research</span><span>Design
                                Tokens</span><span>Figma</span><span>Framer</span><span>ProtoPie</span><span>Leadership</span><span>Public
                                Speaking</span><span>Workshop Facilitation</span>
                        </div>
                    </div>

                    <div class="candidate-section" id="portfolio">
                        <div class="section-head">
                            <h3>Selected case studies</h3>
                            <a href="#.">View full portfolio</a>
                        </div>
                        <div class="portfolio-grid">
                            <article class="portfolio-card">
                                <img src="images/portfolio/portfolio-img1.html" alt="Northwind checkout redesign" />
                                <div>
                                    <h4>Northwind Checkout</h4>
                                    <p>
                                        Commerce redesign for complex B2B orders with scheduled
                                        delivery.
                                    </p>
                                </div>
                            </article>
                            <article class="portfolio-card">
                                <img src="images/portfolio/portfolio-img2.html" alt="Tailspin loyalty" />
                                <div>
                                    <h4>Tailspin Loyalty</h4>
                                    <p>
                                        Omnichannel membership program used by 6M parents
                                        globally.
                                    </p>
                                </div>
                            </article>
                            <article class="portfolio-card">
                                <img src="images/portfolio/portfolio-img3.html" alt="Ops cockpit" />
                                <div>
                                    <h4>Ops Cockpit</h4>
                                    <p>Internal tooling suite replacing 12 legacy screens.</p>
                                </div>
                            </article>
                        </div>
                    </div>

                    <div class="candidate-section">
                        <div class="section-head">
                            <h3>References</h3>
                            <span>What teams say</span>
                        </div>
                        <div class="reference-grid">
                            <article>
                                <p>
                                    “Elliot cares deeply about the craft but also the business
                                    outcomes. He’s turned ambiguous briefs into playbooks the
                                    org still uses.”
                                </p>
                                <div class="reference-meta">
                                    <strong>Ana Castillo</strong>
                                    <span>VP Product · Northwind</span>
                                </div>
                            </article>
                            <article>
                                <p>
                                    “He can facilitate a workshop in the morning and prototype
                                    with engineers that afternoon. Great collaborator with
                                    marketing + ops.”
                                </p>
                                <div class="reference-meta">
                                    <strong>Marcus Young</strong>
                                    <span>Director of Experience · Tailspin</span>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="candidate-side-card contact-card">
                        <h4>Contact Information</h4>
                        <ul class="contact-info-list">
                            <li>
                                <i class="fa-solid fa-phone" aria-hidden="true"></i>
                                <div>
                                    <span>Phone</span>
                                    <strong>+1 234 567 890</strong>
                                </div>
                            </li>
                            <li>
                                <i class="fa-solid fa-mobile-screen" aria-hidden="true"></i>
                                <div>
                                    <span>Mobile</span>
                                    <strong>+1 234 567 978</strong>
                                </div>
                            </li>
                            <li>
                                <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                                <div>
                                    <span>Email</span>
                                    <strong>seeker@jobsportal.com</strong>
                                </div>
                            </li>
                            <li>
                                <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                                <div>
                                    <span>Location</span>
                                    <strong>Dummy Street Address 123, Seattle</strong>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="candidate-side-card details-card">
                        <h4>Candidate Details</h4>
                        <div class="candidate-detail-grid">
                            <article>
                                <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                                <span>Verified</span>
                                <strong>Yes</strong>
                            </article>
                            <article>
                                <i class="fa-solid fa-handshake" aria-hidden="true"></i>
                                <span>Ready for Hire</span>
                                <strong>Yes</strong>
                            </article>
                            <article>
                                <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                                <span>Age</span>
                                <strong>36 years</strong>
                            </article>
                            <article>
                                <i class="fa-regular fa-user" aria-hidden="true"></i>
                                <span>Gender</span>
                                <strong>Male</strong>
                            </article>
                            <article>
                                <i class="fa-regular fa-heart" aria-hidden="true"></i>
                                <span>Marital Status</span>
                                <strong>Single</strong>
                            </article>
                            <article>
                                <i class="fa-solid fa-briefcase" aria-hidden="true"></i>
                                <span>Experience</span>
                                <strong>9 years</strong>
                            </article>
                            <article>
                                <i class="fa-solid fa-diagram-project" aria-hidden="true"></i>
                                <span>Career Level</span>
                                <strong>Lead / Principal</strong>
                            </article>
                            <article>
                                <i class="fa-solid fa-globe" aria-hidden="true"></i>
                                <span>Location</span>
                                <strong>Seattle, USA</strong>
                            </article>
                            <article>
                                <i class="fa-solid fa-dollar-sign" aria-hidden="true"></i>
                                <span>Current Salary</span>
                                <strong>$120k</strong>
                            </article>
                            <article>
                                <i class="fa-solid fa-money-bill-wave" aria-hidden="true"></i>
                                <span>Expected Salary</span>
                                <strong>$165k</strong>
                            </article>
                        </div>
                    </div>
                    <div class="candidate-side-card highlight">
                        <h4>Availability</h4>
                        <p>
                            Exploring fractional design leadership roles (20–30 hrs / week)
                            with remote-first teams in fintech or productivity.
                        </p>
                        <div class="availability-tags">
                            <span>Remote</span><span>Contract</span><span>Travel OK</span>
                        </div>
                    </div>
                    <div class="candidate-side-card">
                        <h4>Toolbox</h4>
                        <div class="tool-stack">
                            <span>Figma</span><span>FigJam</span><span>Principle</span><span>Notion</span><span>Storybook</span><span>Adobe
                                CC</span>
                        </div>
                    </div>
                    <div class="candidate-side-card" id="contact">
                        <h4>Contact Elliot</h4>
                        <form class="candidate-contact-form">
                            <div class="form-group">
                                <label for="contactName">Your Name</label>
                                <input id="contactName" type="text" class="form-control"
                                    placeholder="Jane Recruiter" />
                            </div>
                            <div class="form-group">
                                <label for="contactEmail">Work Email</label>
                                <input id="contactEmail" type="email" class="form-control"
                                    placeholder="jane@company.com" />
                            </div>
                            <div class="form-group">
                                <label for="contactMsg">Message</label>
                                <textarea id="contactMsg" class="form-control" rows="4" placeholder="Tell Elliot about the opportunity..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                Send message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
