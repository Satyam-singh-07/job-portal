@extends('layouts.app')

@section('title', 'Employer Dashboard')

@section('content')


    <section class="dashboard-section profile-settings">
        <div class="container">
            <div class="dashboard-layout">

                @include('employers.partials.sidebar')

                <div class="dashboard-main">
                    <div class="settings-header">

                        <div class="avatar-upload">
                            <img src="{{ asset('images/employers/01.jpg') }}"
                                alt="{{ auth()->user()->company_name . ' logo' }}" />
                            <label class="upload-label">
                                <input type="file" />
                                <i class="fa-solid fa-arrow-up-from-bracket" aria-hidden="true"></i>
                                Update Photo
                            </label>
                        </div>
                        <div class="settings-header-content">
                            <span>Company Profile</span>
                            <h2>{{ auth()->user()->company_name }}</h2>

                            @for ($i = 0; $i < floor(auth()->user()->rating); $i++)
                                <i class="fa-solid fa-star" aria-hidden="true"></i>
                            @endfor
                            @if (auth()->user()->rating - floor(auth()->user()->rating) >= 0.5)
                                <i class="fa-solid fa-star-half-stroke" aria-hidden="true"></i>
                            @endif
                            <span class="rating-value">{{ number_format(auth()->user()->rating, 1) }}</span>

                            <p>
                                Keep your information fresh so hiring teams understand your
                                intent, availability and the type of roles you’re excited
                                about.
                            </p>
                            <div class="settings-header-meta">

                                @if (auth()->user()->team_size)
                                    <span><i class="fa-solid fa-users" aria-hidden="true"></i>
                                        {{ auth()->user()->team_size }}</span>
                                @endif


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
                                        Company Profile
                                    </p>
                                    <h3>Company Information</h3>
                                    <p>
                                        These details power your public profile and Company Profile
                                        cards.
                                    </p>
                                </div>
                               
                            </div>
                            <div class="settings-grid">
                                <div>
                                    <label for="profileFullName" class="form-label">Company name</label>
                                    <input type="text" class="form-control" id="profileFullName" name="company_name"
                                        value="{{ auth()->user()->company_name }}" placeholder="Jordan Blake" />
                                </div>
                                <div>
                                    <label for="profileTitle" class="form-label">Industry</label>

                                    <select class="form-select" id="profileTitle" name="industry">



                                        <option value="">-- Select Industry --</option>

                                        <option value="3D Printing">3D Printing</option>
                                        <option value="Accounting / Auditing">Accounting / Auditing</option>
                                        <option value="Advertising & Marketing">Advertising & Marketing</option>
                                        <option value="Agri-tech">Agri-tech</option>
                                        <option value="Agriculture / Forestry / Fishing">Agriculture / Forestry / Fishing
                                        </option>
                                        <option value="AI/ML">AI/ML</option>
                                        <option value="Airlines / Aviation / Aerospace">Airlines / Aviation / Aerospace
                                        </option>
                                        <option value="Analytics / KPO / Research">Analytics / KPO / Research</option>
                                        <option value="Animation & VFX">Animation & VFX</option>
                                        <option value="AR/VR">AR/VR</option>
                                        <option value="Architecture / Interior Design">Architecture / Interior Design
                                        </option>
                                        <option value="Asset Management & Financial Services">Asset Management & Financial
                                            Services</option>
                                        <option value="Auto Components">Auto Components</option>
                                        <option value="Automobile">Automobile</option>
                                        <option value="Automobile Dealership">Automobile Dealership</option>
                                        <option value="Banking">Banking</option>
                                        <option value="Beauty, Wellness & Personal Care">Beauty, Wellness & Personal Care
                                        </option>
                                        <option value="Beverage">Beverage</option>
                                        <option value="Biotech">Biotech</option>
                                        <option value="Blockchain">Blockchain</option>
                                        <option value="BPO / Call Centre">BPO / Call Centre</option>
                                        <option value="Brewery / Distillery">Brewery / Distillery</option>
                                        <option value="Financial Broking">Financial Broking</option>
                                        <option value="Building Material">Building Material</option>
                                        <option value="Cement Manufacturing">Cement Manufacturing</option>
                                        <option value="Ceramic Manufacturing">Ceramic Manufacturing</option>
                                        <option value="Chemicals">Chemicals</option>
                                        <option value="Clinical Research / Contract Research">Clinical Research / Contract
                                            Research</option>
                                        <option value="Cloud Technology">Cloud Technology</option>
                                        <option value="Co Working / Asset Management">Co Working / Asset Management</option>
                                        <option value="Construction Equipment">Construction Equipment</option>
                                        <option value="Consumer Electronics & Appliances">Consumer Electronics & Appliances
                                        </option>
                                        <option value="Content Development / Language">Content Development / Language
                                        </option>
                                        <option value="Courier / Logistics">Courier / Logistics</option>
                                        <option value="Cybersecurity">Cybersecurity</option>
                                        <option value="Dairy Processing">Dairy Processing</option>
                                        <option value="Defence & Aerospace">Defence & Aerospace</option>
                                        <option value="Graphic Design">Graphic Design</option>
                                        <option value="Diagnostics">Diagnostics</option>
                                        <option value="Digital Marketing">Digital Marketing</option>
                                        <option value="Drones/Robotics">Drones/Robotics</option>
                                        <option value="E-Commerce">E-Commerce</option>
                                        <option value="E-Learning / EdTech">E-Learning / EdTech</option>
                                        <option value="Education">Education</option>
                                        <option value="Training">Training</option>
                                        <option value="Electric Vehicle (EV)">Electric Vehicle (EV)</option>
                                        <option value="Electrical Equipment">Electrical Equipment</option>
                                        <option value="Electronic Components / Semiconductors">Electronic Components /
                                            Semiconductors</option>
                                        <option value="Electronic Manufacturing Services (EMS)">Electronic Manufacturing
                                            Services (EMS)</option>
                                        <option value="Engineering & Construction">Engineering & Construction</option>
                                        <option value="Events / Live Entertainment">Events / Live Entertainment</option>
                                        <option value="Facility Management Services">Facility Management Services</option>
                                        <option value="Fashion">Fashion</option>
                                        <option value="Fertilizers / Pesticides / Agro-chemicals">Fertilizers / Pesticides
                                            / Agro-chemicals</option>
                                        <option value="Film / Music / Entertainment">Film / Music / Entertainment</option>
                                        <option value="Financial Services">Financial Services</option>
                                        <option value="FinTech / Payments">FinTech / Payments</option>
                                        <option value="Fitness & Wellness">Fitness & Wellness</option>
                                        <option value="FMCG">FMCG</option>
                                        <option value="Food Processing">Food Processing</option>
                                        <option value="Furniture & Furnishing">Furniture & Furnishing</option>
                                        <option value="Gaming">Gaming</option>
                                        <option value="Gold, Gems & Jewellery">Gold, Gems & Jewellery</option>
                                        <option value="Glass Manufacturing">Glass Manufacturing</option>
                                        <option value="Government / Public Administration">Government / Public
                                            Administration</option>
                                        <option value="Handicraft">Handicraft</option>
                                        <option value="Hardware & Networking">Hardware & Networking</option>
                                        <option value="Home Textile">Home Textile</option>
                                        <option value="Hotels & Restaurants">Hotels & Restaurants</option>

                                    </select>

                                </div>
                                <div>
                                    <label for="profileEmail" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="profileEmail" name="email"
                                        value="{{ auth()->user()->email }}" placeholder="you@company.com" />
                                </div>
                                <div>
                                    <label for="profilePhone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="profilePhone"
                                        placeholder="+1 234 567 890" />
                                </div>
                                <div>
                                    <label for="profileLocation" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="profileLocation"
                                        placeholder="Seattle, USA" />
                                </div>

                                <div>
                                    <label for="profileWebsite" class="form-label">Website</label>
                                    <input type="url" class="form-control" id="profileWebsite" name="website"
                                        value="{{ auth()->user()->website ?? '' }}"
                                        placeholder="https://www.personal-site.com/" />
                                </div>
                                <div>
                                    <label for="profilePortfolio" class="form-label">Tagline</label>
                                    <input type="text" class="form-control" id="profilePortfolio" name="tagline"
                                        value="{{ auth()->user()->tagline ?? '' }}" placeholder="Your tagline here" />
                                </div>
                                <div>
                                    <label for="profilePortfolio" class="form-label">Company Size</label>
                                    <input type="text" class="form-control" id="profilePortfolio" name="company_size"
                                        value="{{ auth()->user()->team_size ?? '' }}"
                                        placeholder="e.g. 100-250 employees" />
                                </div>
                                <div class="grid-span-2">
                                    <label for="profileSummary" class="form-label">About Company (Who We Are)</label>
                                    <textarea class="form-control" id="profileSummary" name="summary"
                                        placeholder="Summarize your superpowers, recent wins, and what you’re looking for next.">{{ auth()->user()->summary ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>



                        <div class="settings-card">
                            <div class="settings-card-header">
                                <div>
                                    <p class="text-uppercase text-muted small fw-semibold mb-1">
                                        What We Value
                                    </p>
                                    <h3>Our Core Values</h3>
                                    <p>
                                        Share the principles that guide your culture and the type of
                                        candidates who would thrive.
                                    </p>
                                </div>
                            </div>
                            <div class="skill-tags">
                                <div class="skill-tag">
                                    <span>Collaboration</span>
                                </div>
                                <div class="skill-tag">
                                    <span>Ownership</span>
                                </div>
                                <div class="skill-tag">
                                    <span>Customer-centricity</span>
                                </div>
                                <div class="skill-tag">
                                    <span>Innovation</span>
                                </div>
                                <div class="skill-tag">
                                    <span>Diversity & Inclusion</span>
                                </div>
                                <div class="skill-tag">
                                    <span>Continuous Learning</span>
                                </div>

                            </div>
                            <button type="button" class="add-skill-btn">
                                <i class="fa-solid fa-plus" aria-hidden="true"></i> Add Values
                            </button>
                        </div>




                        <div class="settings-card">
                            <div class="settings-card-header">
                                <div>
                                    <p class="text-uppercase text-muted small fw-semibold mb-1">
                                        Company Journey
                                    </p>
                                    <h3>Life at {{ auth()->user()->company_name }}</h3>
                                    <p>
                                        Highlight key roles, milestones, or projects that showcase your company’s growth and
                                        impact. This can help candidates understand your trajectory and the type of work
                                        they might be involved in.
                                    </p>
                                </div>
                            </div>
                            <div class="skill-tags">
                                <div class="skill-tag">
                                    <span>Remote-Friendly</span>
                                </div>
                                <div class="skill-tag">
                                    <span>Health + Wellness</span>
                                </div>
                                <div class="skill-tag">
                                    <span>Professional Development</span>
                                </div>
                                <div class="skill-tag">
                                    <span>Community Engagement</span>
                                </div>

                            </div>
                            <button type="button" class="add-skill-btn">
                                <i class="fa-solid fa-plus" aria-hidden="true"></i> Add Values
                            </button>
                        </div>




                        {{-- gallery of images, videos, or documents that showcase your company culture, products, or team in action. This can help candidates get a better sense of what it's like to work at your company and make your profile more engaging.
                         --}}

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <div>
                                    <p class="text-uppercase text-muted small fw-semibold mb-1">
                                        Media Gallery
                                    </p>
                                    <h3>Showcase Your Company</h3>
                                    <p>
                                        Upload images, videos, or documents that highlight your company culture, products,
                                        or team in action.
                                    </p>
                                </div>
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-3">
                                    <i class="fa-solid fa-circle-plus" aria-hidden="true"></i>
                                    Add media
                                </button>
                            </div>
                            <div class="media-gallery">
                                <div class="media-item">
                                    <img src="{{ asset('images/employers/02.jpg') }}" alt="Company culture" />
                                    <span>Office culture</span>
                                </div>
                                <div class="media-item">
                                    <img src="{{ asset('images/employers/03.jpg') }}" alt="Product showcase" />
                                    <span>Product showcase</span>
                                </div>
                                <div class="media-item">
                                    <img src="{{ asset('images/employers/04.jpg') }}" alt="Team event" />
                                    <span>Team event</span>
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
