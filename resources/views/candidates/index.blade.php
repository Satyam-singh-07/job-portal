@extends('layouts.app')

@section('title', 'Candidate Directory - List View')

@section('content')

    <section class="jobs-hero talent-hero">
        <div class="container">
            <div class="jobs-hero-wrapper">
                <span class="jobs-hero-badge">Search the talent cloud</span>
                <h1 class="jobs-hero-title">Curate shortlists with confidence</h1>
                <p class="jobs-hero-copy">
                    Filter by skills, availability, and compensation to surface
                    candidates aligned with your brief.
                </p>
                <form class="jobs-hero-form">
                    <div class="row g-3">
                        <div class="col-lg-5 col-md-6">
                            <label class="jobs-hero-field">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <input type="text" class="form-control" placeholder="Name, title or keyword" />
                            </label>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="jobs-hero-field select-field">
                                <i class="fa fa-location-dot" aria-hidden="true"></i>
                                <select class="form-select">
                                    <option selected>Preferred location</option>
                                    <option>Remote only</option>
                                    <option>USA - West Coast</option>
                                    <option>Europe</option>
                                    <option>APAC</option>
                                </select>
                            </label>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="jobs-hero-field select-field">
                                <i class="fa fa-tag" aria-hidden="true"></i>
                                <select class="form-select">
                                    <option selected>Speciality</option>
                                    <option>Product Design</option>
                                    <option>Frontend</option>
                                    <option>Data Science</option>
                                    <option>Marketing</option>
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

    <section class="jobs-board candidates-board">
        <div class="container">
            <div class="row g-4">
                <aside class="col-lg-3">
                    <div class="filter-card spotlight">
                        <h5>Search candidates</h5>
                        <label class="filter-field"><i class="fa fa-user" aria-hidden="true"></i><input type="text"
                                class="form-control" placeholder="Name or keyword" /></label>
                        <label class="filter-field"><i class="fa fa-location-dot" aria-hidden="true"></i><input
                                type="text" class="form-control" placeholder="Preferred location" /></label>
                        <label class="filter-field"><i class="fa fa-lightbulb" aria-hidden="true"></i><input type="text"
                                class="form-control" placeholder="Key skill or tool" /></label>
                        <div class="filter-switch form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="openToRelocateList" />
                            <label class="form-check-label" for="openToRelocateList">Open to relocate</label>
                        </div>
                        <button class="btn btn-primary w-100">Apply filters</button>
                    </div>
                    <div class="filter-card">
                        <h5>Experience level</h5>
                        <ul class="filter-list">
                            <li>
                                <label><input type="checkbox" /> 1-3 years <span>8</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> 4-6 years <span>14</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> 7-10 years <span>11</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> 10+ years <span>9</span></label>
                            </li>
                        </ul>
                    </div>
                    <div class="filter-card">
                        <h5>Availability</h5>
                        <ul class="filter-list">
                            <li>
                                <label><input type="checkbox" /> Immediately available
                                    <span>12</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Two weeks notice
                                    <span>18</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Contract / fractional
                                    <span>6</span></label>
                            </li>
                        </ul>
                    </div>
                    <div class="filter-card">
                        <h5>Expertise focus</h5>
                        <ul class="filter-list">
                            <li>
                                <label><input type="checkbox" /> Product Design
                                    <span>15</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Engineering
                                    <span>13</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Research &amp; Insights
                                    <span>9</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Growth &amp; Marketing
                                    <span>7</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Data Science
                                    <span>6</span></label>
                            </li>
                        </ul>
                    </div>
                    <div class="filter-card">
                        <h5>Work model</h5>
                        <ul class="filter-list">
                            <li>
                                <label><input type="checkbox" /> Remote <span>29</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> Hybrid <span>13</span></label>
                            </li>
                            <li>
                                <label><input type="checkbox" /> On-site <span>4</span></label>
                            </li>
                        </ul>
                    </div>
                </aside>
                <div class="col-lg-9">
                    <div class="jobs-board-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <h2>42 Candidates Found</h2>
                            <span class="jobs-count">Showing 1 - 12 curated job seekers</span>
                        </div>
                        <div class="jobs-actions d-flex align-items-center gap-3 flex-wrap">
                            <div class="jobs-view-toggle" role="group" aria-label="Toggle candidate view">
                                <a href="candidate-listing.html" class="view-btn" aria-label="Grid view"><i
                                        class="fa fa-th-large" aria-hidden="true"></i></a>
                                <a href="candidate-listing-list.html" class="view-btn active" aria-label="List view"><i
                                        class="fa fa-bars" aria-hidden="true"></i></a>
                            </div>
                            <div class="jobs-sort d-flex align-items-center gap-2">
                                <select class="form-select">
                                    <option selected>Most relevant</option>
                                    <option>Newest availability</option>
                                    <option>Years of experience</option>
                                    <option>Comp expectation</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="candidate-list">
                        <article class="candidate-list-item">
                            <div class="candidate-list-avatar">
                                <img src="images/candidates/01.jpg" alt="Amelia Stone" />
                            </div>
                            <div class="candidate-list-main">
                                <div class="candidate-list-top">
                                    <div>
                                        <span class="candidate-badge available">Open to work</span>
                                        <h4><a href="candidate-detail.html">Amelia Stone</a></h4>
                                        <p>Lead Product Designer · 8 yrs exp · Remote, Seattle</p>
                                    </div>
                                    <button class="candidate-save" aria-label="Save candidate">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </button>
                                </div>
                                <p class="candidate-summary">
                                    Previously at Stripe and Lattice. Scaled design systems
                                    across 40+ squads and led a team of 6 designers owning
                                    payments experience.
                                </p>
                                <div class="candidate-tags">
                                    <span>Design Systems</span><span>Figma</span><span>Team
                                        Leadership</span><span>Fintech</span>
                                </div>
                            </div>
                            <div class="candidate-list-meta">
                                <div class="candidate-rate">
                                    <span>Expected</span><strong>$140k - $160k</strong>
                                </div>
                                <button class="btn btn-outline-primary w-100">
                                    View profile
                                </button>
                            </div>
                        </article>

                        <article class="candidate-list-item">
                            <div class="candidate-list-avatar">
                                <img src="images/candidates/02.html" alt="Noah Greene" />
                            </div>
                            <div class="candidate-list-main">
                                <div class="candidate-list-top">
                                    <div>
                                        <span class="candidate-badge interviewing">Interviewing</span>
                                        <h4><a href="candidate-detail.html">Noah Greene</a></h4>
                                        <p>
                                            Senior Frontend Engineer · 10 yrs exp · Berlin, Germany
                                        </p>
                                    </div>
                                    <button class="candidate-save" aria-label="Save candidate">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </button>
                                </div>
                                <p class="candidate-summary">
                                    Built performant design systems and storefront experiences
                                    for commerce leaders. Mentors FE guilds and drives
                                    accessibility initiatives.
                                </p>
                                <div class="candidate-tags">
                                    <span>React</span><span>TypeScript</span><span>Accessibility</span><span>Experience
                                        Architecture</span>
                                </div>
                            </div>
                            <div class="candidate-list-meta">
                                <div class="candidate-rate">
                                    <span>Expected</span><strong>€95k - €110k</strong>
                                </div>
                                <button class="btn btn-outline-primary w-100">
                                    View profile
                                </button>
                            </div>
                        </article>

                        <article class="candidate-list-item">
                            <div class="candidate-list-avatar">
                                <img src="images/candidates/03.html" alt="Priya Narayan" />
                            </div>
                            <div class="candidate-list-main">
                                <div class="candidate-list-top">
                                    <div>
                                        <span class="candidate-badge available">Available May 1</span>
                                        <h4><a href="candidate-detail.html">Priya Narayan</a></h4>
                                        <p>Data Scientist · 6 yrs exp · Singapore · Hybrid</p>
                                    </div>
                                    <button class="candidate-save" aria-label="Save candidate">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </button>
                                </div>
                                <p class="candidate-summary">
                                    Specialised in clinical analytics and ML Ops. Deployed risk
                                    models across APAC hospitals with 20% accuracy lift.
                                </p>
                                <div class="candidate-tags">
                                    <span>Python</span><span>ML Ops</span><span>Clinical Analytics</span><span>Azure</span>
                                </div>
                            </div>
                            <div class="candidate-list-meta">
                                <div class="candidate-rate">
                                    <span>Expected</span><strong>S$120k - S$140k</strong>
                                </div>
                                <button class="btn btn-outline-primary w-100">
                                    View profile
                                </button>
                            </div>
                        </article>

                        <article class="candidate-list-item">
                            <div class="candidate-list-avatar">
                                <img src="images/candidates/04.html" alt="Mateo Alvarez" />
                            </div>
                            <div class="candidate-list-main">
                                <div class="candidate-list-top">
                                    <div>
                                        <span class="candidate-badge available">Open to contracts</span>
                                        <h4><a href="candidate-detail.html">Mateo Alvarez</a></h4>
                                        <p>Growth Marketing Lead · 9 yrs exp · Austin, TX</p>
                                    </div>
                                    <button class="candidate-save" aria-label="Save candidate">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </button>
                                </div>
                                <p class="candidate-summary">
                                    Fractional growth partner for 6 B2B SaaS startups. Known for
                                    lifecycle rebuilds and revenue orchestration playbooks.
                                </p>
                                <div class="candidate-tags">
                                    <span>Lifecycle</span><span>Paid Media</span><span>RevOps</span><span>HubSpot</span>
                                </div>
                            </div>
                            <div class="candidate-list-meta">
                                <div class="candidate-rate">
                                    <span>Expected</span><strong>$95/hr · $180k</strong>
                                </div>
                                <button class="btn btn-outline-primary w-100">
                                    View profile
                                </button>
                            </div>
                        </article>

                        <article class="candidate-list-item">
                            <div class="candidate-list-avatar">
                                <img src="images/candidates/05.html" alt="Sara Holm" />
                            </div>
                            <div class="candidate-list-main">
                                <div class="candidate-list-top">
                                    <div>
                                        <span class="candidate-badge interviewing">Interviewing</span>
                                        <h4><a href="candidate-detail.html">Sara Holm</a></h4>
                                        <p>UX Research Manager · 11 yrs exp · Stockholm</p>
                                    </div>
                                    <button class="candidate-save" aria-label="Save candidate">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </button>
                                </div>
                                <p class="candidate-summary">
                                    Built research functions for Nordic fintechs. Expert in
                                    mixed-methods, executive storytelling, and
                                    insight-to-roadmap programs.
                                </p>
                                <div class="candidate-tags">
                                    <span>Mixed Methods</span><span>Journey Mapping</span><span>Stakeholder Mgmt</span>
                                </div>
                            </div>
                            <div class="candidate-list-meta">
                                <div class="candidate-rate">
                                    <span>Expected</span><strong>€85k - €95k</strong>
                                </div>
                                <button class="btn btn-outline-primary w-100">
                                    View profile
                                </button>
                            </div>
                        </article>

                        <article class="candidate-list-item">
                            <div class="candidate-list-avatar">
                                <img src="images/candidates/06.html" alt="Lena Park" />
                            </div>
                            <div class="candidate-list-main">
                                <div class="candidate-list-top">
                                    <div>
                                        <span class="candidate-badge available">Open to remote</span>
                                        <h4><a href="candidate-detail.html">Lena Park</a></h4>
                                        <p>AI Product Manager · 7 yrs exp · Toronto</p>
                                    </div>
                                    <button class="candidate-save" aria-label="Save candidate">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </button>
                                </div>
                                <p class="candidate-summary">
                                    Shipped AI copilots for enterprise productivity suites.
                                    Former founder with deep LLM strategy + GTM background.
                                </p>
                                <div class="candidate-tags">
                                    <span>LLM Strategy</span><span>Agile Delivery</span><span>Stakeholder Mgmt</span>
                                </div>
                            </div>
                            <div class="candidate-list-meta">
                                <div class="candidate-rate">
                                    <span>Expected</span><strong>$150k - $170k</strong>
                                </div>
                                <button class="btn btn-outline-primary w-100">
                                    View profile
                                </button>
                            </div>
                        </article>
                    </div>

                    <div class="jobs-pagination mt-4 d-flex flex-wrap align-items-center justify-content-between">
                        <span class="jobs-count">Showing 1 - 12 of 42</span>
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
