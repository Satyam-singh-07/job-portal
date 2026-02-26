@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

    <section class="dashboard-section profile-settings">
        <div class="container">
            <div class="dashboard-layout">

                @include('candidates.partials.sidebar')

                <div class="dashboard-main">
                    <div class="settings-header">
                        <div class="avatar-upload">
                            <img src="{{ asset('images/candidates/01.jpg') }}" alt="Job Seeker" />
                            <label class="upload-label">
                                <input type="file" />
                                <i class="fa-solid fa-arrow-up-from-bracket" aria-hidden="true"></i>
                                Update Photo
                            </label>
                        </div>
                        <div class="settings-header-content">
                            <span>Candidate Profile</span>
                            <h2>Job Seeker</h2>
                            <p>
                                Keep your information fresh so hiring teams understand your
                                intent, availability and the type of roles you’re excited
                                about.
                            </p>
                            <div class="settings-header-meta">
                                <span><i class="fa-solid fa-briefcase" aria-hidden="true"></i>
                                    Product Design Lead</span>
                                <span><i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                                    Remote · USA</span>
                                <span><i class="fa-solid fa-clock" aria-hidden="true"></i>
                                    Updated 2 days ago</span>
                            </div>
                        </div>
                    </div>

                    <form class="settings-form" action="#." method="post">
                        <div class="settings-card">
                            <div class="settings-card-header">
                                <div>
                                    <p class="text-uppercase text-muted small fw-semibold mb-1">
                                        Profile
                                    </p>
                                    <h3>Personal Information</h3>
                                    <p>
                                        These details power your public profile and application
                                        cards.
                                    </p>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm rounded-3">
                                    <i class="fa-solid fa-file-arrow-up" aria-hidden="true"></i>
                                    Upload résumé
                                </button>
                            </div>
                            <div class="settings-grid">
                                <div>
                                    <label for="profileFullName" class="form-label">Full name</label>
                                    <input type="text" class="form-control" id="profileFullName"
                                        placeholder="Jordan Blake" />
                                </div>
                                <div>
                                    <label for="profileTitle" class="form-label">Professional title</label>
                                    <input type="text" class="form-control" id="profileTitle"
                                        placeholder="Lead Product Designer" />
                                </div>
                                <div>
                                    <label for="profileEmail" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="profileEmail"
                                        placeholder="you@company.com" />
                                </div>
                                <div>
                                    <label for="profilePhone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="profilePhone"
                                        placeholder="+1 234 567 890" />
                                </div>
                                <div>
                                    <label for="profileLocation" class="form-label">Primary location</label>
                                    <input type="text" class="form-control" id="profileLocation"
                                        placeholder="Seattle, USA" />
                                </div>
                                <div>
                                    <label for="profilePreferredLocation" class="form-label">Preferred locations</label>
                                    <input type="text" class="form-control" id="profilePreferredLocation"
                                        placeholder="Remote · San Francisco · Berlin" />
                                </div>
                                <div>
                                    <label for="profileWebsite" class="form-label">Website</label>
                                    <input type="url" class="form-control" id="profileWebsite"
                                        placeholder="https://www.personal-site.com/" />
                                </div>
                                <div>
                                    <label for="profilePortfolio" class="form-label">Portfolio / Case study</label>
                                    <input type="url" class="form-control" id="profilePortfolio"
                                        placeholder="https://dribbble.com/jordan" />
                                </div>
                                <div class="grid-span-2">
                                    <label for="profileSummary" class="form-label">About you</label>
                                    <textarea class="form-control" id="profileSummary"
                                        placeholder="Summarize your superpowers, recent wins, and what you’re looking for next."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <div>
                                    <p class="text-uppercase text-muted small fw-semibold mb-1">
                                        Career
                                    </p>
                                    <h3>Professional Snapshot</h3>
                                    <p>Showcase your current standing and ideal role.</p>
                                </div>
                            </div>
                            <div class="settings-grid">
                                <div>
                                    <label for="experienceLevel" class="form-label">Experience level</label>
                                    <select class="form-select" id="experienceLevel">
                                        <option selected>10+ years</option>
                                        <option>8-10 years</option>
                                        <option>5-7 years</option>
                                        <option>2-4 years</option>
                                        <option>Entry level</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="currentCompany" class="form-label">Current company</label>
                                    <input type="text" class="form-control" id="currentCompany"
                                        placeholder="Skyline Digital" />
                                </div>
                                <div>
                                    <label for="noticePeriod" class="form-label">Notice period</label>
                                    <select class="form-select" id="noticePeriod">
                                        <option selected>2 weeks</option>
                                        <option>1 week</option>
                                        <option>30 days</option>
                                        <option>45 days</option>
                                        <option>Immediately available</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="employmentType" class="form-label">Desired employment</label>
                                    <select class="form-select" id="employmentType">
                                        <option selected>Full-time</option>
                                        <option>Contract</option>
                                        <option>Freelance</option>
                                        <option>Internship</option>
                                        <option>Part-time</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="salaryRange" class="form-label">Salary expectation</label>
                                    <input type="text" class="form-control" id="salaryRange"
                                        placeholder="USD 120k – 150k / year" />
                                </div>
                                <div>
                                    <label for="workPreference" class="form-label">Work preference</label>
                                    <select class="form-select" id="workPreference">
                                        <option selected>Remote friendly</option>
                                        <option>On-site only</option>
                                        <option>Hybrid</option>
                                    </select>
                                </div>
                                <div class="grid-span-2">
                                    <label for="dreamRoles" class="form-label">Target roles</label>
                                    <textarea class="form-control" id="dreamRoles"
                                        placeholder="Principal Product Designer, Product Design Manager, Design Lead"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <div>
                                    <p class="text-uppercase text-muted small fw-semibold mb-1">
                                        Skills
                                    </p>
                                    <h3>Skills &amp; Tools</h3>
                                    <p>Highlight stacks, frameworks, and certifications.</p>
                                </div>
                            </div>
                            <div class="skill-tags">
                                <span class="skill-tag">Product Strategy</span>
                                <span class="skill-tag">Design Systems</span>
                                <span class="skill-tag">Figma</span>
                                <span class="skill-tag">React</span>
                                <span class="skill-tag">UX Research</span>
                            </div>
                            <button type="button" class="add-skill-btn">
                                <i class="fa-solid fa-plus" aria-hidden="true"></i> Add skill
                            </button>
                        </div>

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <div>
                                    <p class="text-uppercase text-muted small fw-semibold mb-1">
                                        Experience
                                    </p>
                                    <h3>Experience &amp; Education</h3>
                                    <p>Keep your latest role and flagship education updated.</p>
                                </div>
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-3">
                                    <i class="fa-solid fa-circle-plus" aria-hidden="true"></i>
                                    Add entry
                                </button>
                            </div>
                            <div class="settings-grid">
                                <div>
                                    <label for="expCompany" class="form-label">Company</label>
                                    <input type="text" class="form-control" id="expCompany"
                                        placeholder="Skyline Digital" />
                                </div>
                                <div>
                                    <label for="expRole" class="form-label">Role</label>
                                    <input type="text" class="form-control" id="expRole"
                                        placeholder="Lead Product Designer" />
                                </div>
                                <div>
                                    <label for="expStart" class="form-label">Start date</label>
                                    <input type="month" class="form-control" id="expStart" />
                                </div>
                                <div>
                                    <label for="expEnd" class="form-label">End date</label>
                                    <input type="month" class="form-control" id="expEnd" />
                                </div>
                                <div class="grid-span-2">
                                    <label for="expHighlights" class="form-label">Key highlights</label>
                                    <textarea class="form-control" id="expHighlights"
                                        placeholder="Scaled design system, mentored 6 designers, partnered with research to ship 4 product lines."></textarea>
                                </div>
                                <div>
                                    <label for="eduSchool" class="form-label">Education</label>
                                    <input type="text" class="form-control" id="eduSchool"
                                        placeholder="Stanford · BSc Human Computer Interaction" />
                                </div>
                                <div>
                                    <label for="eduYear" class="form-label">Graduation year</label>
                                    <input type="text" class="form-control" id="eduYear" placeholder="2014" />
                                </div>
                            </div>
                        </div>

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <div>
                                    <p class="text-uppercase text-muted small fw-semibold mb-1">
                                        Links
                                    </p>
                                    <h3>Social &amp; Contact Links</h3>
                                    <p>
                                        Share channels where hiring teams can follow your work.
                                    </p>
                                </div>
                            </div>
                            <div class="settings-grid">
                                <div>
                                    <label for="linkLinkedIn" class="form-label">LinkedIn</label>
                                    <input type="url" class="form-control" id="linkLinkedIn"
                                        placeholder="https://www.linkedin.com/in/username" />
                                </div>
                                <div>
                                    <label for="linkDribbble" class="form-label">Dribbble</label>
                                    <input type="url" class="form-control" id="linkDribbble"
                                        placeholder="https://dribbble.com/username" />
                                </div>
                                <div>
                                    <label for="linkGithub" class="form-label">GitHub / Code</label>
                                    <input type="url" class="form-control" id="linkGithub"
                                        placeholder="https://github.com/username" />
                                </div>
                                <div>
                                    <label for="linkTwitter" class="form-label">Twitter / X</label>
                                    <input type="url" class="form-control" id="linkTwitter"
                                        placeholder="https://twitter.com/username" />
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-outline-secondary">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
