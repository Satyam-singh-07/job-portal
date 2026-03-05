@extends('layouts.app')

@php
    $siteName = config('app.name', 'Job Portal');
    $homeTitle = 'Find Jobs, Companies, and Career Opportunities';
    $homeDescription = 'Discover verified jobs, explore top hiring companies, and apply quickly with '.$siteName.'.';
@endphp

@section('title', $homeTitle.' | '.$siteName)
@section('meta_description', $homeDescription)
@section('canonical_url', route('home'))
@section('og_title', $homeTitle.' | '.$siteName)
@section('og_description', $homeDescription)
@section('og_url', route('home'))

@push('structured_data')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => $siteName,
    'url' => route('home'),
    'potentialAction' => [
        '@type' => 'SearchAction',
        'target' => route('jobs.index').'?search={search_term_string}',
        'query-input' => 'required name=search_term_string',
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => $siteName,
    'url' => route('home'),
    'logo' => asset('images/jobs-portal-logo.png'),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'ItemList',
    'name' => 'Featured Jobs on Homepage',
    'numberOfItems' => $featuredJobs->count(),
    'itemListElement' => $featuredJobs->values()->map(function ($job, $index) {
        return [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'url' => route('jobs.show', ['slug' => $job->slug]),
            'name' => $job->title,
        ];
    })->all(),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush

@section('content')

    <!-- Hero start -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <span class="hero-badge">Ready to Find Your Dream Job?</span>
                    <h1 class="hero-title">
                        Take the next step in your career journey.
                    </h1>
                    <p class="hero-copy">
                        Explore opportunities that match your skills and passions,
                        and land the job you've always wanted with {{ $siteName }}.
                    </p>
                    <p class="hero-copy mb-4">
                        <strong>{{ number_format($stats['jobs']) }}</strong> live jobs,
                        <strong>{{ number_format($stats['companies']) }}</strong> active companies,
                        and <strong>{{ number_format($stats['locations']) }}</strong> locations.
                    </p>

                    <form class="hero-search" action="{{ route('jobs.index') }}" method="get">
                        <div class="hero-search-fields">
                            <label class="hero-field">
                                <i class="fa fa-search"></i>
                                <input type="text" name="search" class="form-control" placeholder="Enter skills or job title">
                            </label>

                            <label class="hero-field select-field">
                                <i class="fa fa-map-marker"></i>
                                <select class="form-select" name="location">
                                    <option value="" selected>All Locations</option>
                                    @foreach($heroLocations as $location)
                                        <option value="{{ $location }}">{{ $location }}</option>
                                    @endforeach
                                </select>
                            </label>

                            <label class="hero-field select-field">
                                <i class="fa fa-briefcase"></i>
                                <select class="form-select" name="category">
                                    <option value="" selected>All Categories</option>
                                    @foreach($heroCategories as $category)
                                        <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                            </label>

                            <button type="submit" class="btn hero-submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="col-lg-6">
                    <div class="hero-visual">
                        <img src="{{ asset('images/hero-image.png') }}" class="img-fluid hero-image"
                            alt="Find a perfect job">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero End -->


    <!-- Info Boxes -->
    <div class="infodatawrap">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('jobs.index') }}" class="userloginbox">
                        <h3>Search your desired Job</h3>
                        <p>Discover a career you are passionate about</p>
                        <img src="{{ asset('images/icons/search-job-icon.png') }}" alt="">
                    </a>
                </div>

                <div class="col-md-6">
                    <a href="{{ route('register') }}" class="userloginbox postjobbox">
                        <h3>Post a Job Today</h3>
                        <p>Discover the ideal candidate for your team</p>
                        <img src="{{ asset('images/icons/postjob.png') }}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Companies start -->
    <section class="section company-section">
        <div class="container">
            <div class="titleTop text-center">
                <div class="subtitle">Here You Can See</div>
                <h3>Top Companies are Hiring</h3>
            </div>
            <div class="row g-4 company-grid">
                @forelse($topCompanies as $company)
                    <div class="col-12 col-sm-6 col-lg-3">
                        <a href="{{ route('company.show', ['username' => ltrim((string) $company->username, '@')]) }}" class="company-card">
                            <div class="company-logo">
                                <img src="{{ $company->logo_url }}" alt="{{ $company->company_name ?: 'Company' }}" />
                            </div>
                            <h5>{{ $company->company_name ?: 'Company' }}</h5>
                            <div class="company-meta">
                                <i class="fa fa-industry" aria-hidden="true"></i>
                                {{ $company->industry ?: 'Hiring in multiple industries' }}
                            </div>
                            <div class="company-openings">
                                <i class="fa fa-briefcase" aria-hidden="true"></i>
                                {{ $company->open_jobs_count }} Open {{ $company->open_jobs_count === 1 ? 'Job' : 'Jobs' }}
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted mb-0">No companies with active openings yet.</p>
                    </div>
                @endforelse
            </div>
            <div class="company-viewall text-center">
                <a href="{{ route('employers.index') }}" class="btn btn-primary">View All Featured Companies</a>
            </div>
        </div>
    </section>
    <!-- Top Companies end -->

    <!-- Categories start -->
    <section class="section category-section">
        <div class="container">
            <div class="titleTop text-center">
                <div class="subtitle">Find Your Path</div>
                <h3>Browse Jobs By Categories</h3>
            </div>
            <div class="category-carousel-wrap">
                <div class="category-nav category-prev">
                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                </div>
                <div class="category-nav category-next">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </div>
                <div class="owl-carousel category-carousel">
                    <div class="category-card">
                        <div class="category-icon">
                            <img src="images/categories/business-management.png" alt="Business Management" />
                        </div>
                        <h5>Business Management</h5>
                        <a href="#." class="category-jobs"><i class="fa fa-briefcase" aria-hidden="true"></i> (2)
                            Jobs</a>
                    </div>
                    <div class="category-card">
                        <div class="category-icon">
                            <img src="images/categories/admin.png" alt="Admin" />
                        </div>
                        <h5>Admin</h5>
                        <a href="#." class="category-jobs"><i class="fa fa-briefcase" aria-hidden="true"></i> (2)
                            Jobs</a>
                    </div>
                    <div class="category-card">
                        <div class="category-icon">
                            <img src="images/categories/it.png" alt="Information Technology" />
                        </div>
                        <h5>Information Technology</h5>
                        <a href="#." class="category-jobs"><i class="fa fa-briefcase" aria-hidden="true"></i> (1)
                            Jobs</a>
                    </div>
                    <div class="category-card">
                        <div class="category-icon">
                            <img src="images/categories/development-web.png" alt="Software & Web Development" />
                        </div>
                        <h5>Software &amp; Web Development</h5>
                        <a href="#." class="category-jobs"><i class="fa fa-briefcase" aria-hidden="true"></i> (1)
                            Jobs</a>
                    </div>
                    <div class="category-card">
                        <div class="category-icon">
                            <img src="images/categories/electrician.png" alt="Electronics Technician" />
                        </div>
                        <h5>Electronics Technician</h5>
                        <a href="#." class="category-jobs"><i class="fa fa-briefcase" aria-hidden="true"></i> (1)
                            Jobs</a>
                    </div>
                    <div class="category-card">
                        <div class="category-icon">
                            <img src="images/categories/developer.png" alt="Web Developer" />
                        </div>
                        <h5>Web Developer</h5>
                        <a href="#." class="category-jobs"><i class="fa fa-briefcase" aria-hidden="true"></i> (1)
                            Jobs</a>
                    </div>
                    <div class="category-card">
                        <div class="category-icon">
                            <img src="images/categories/data-admin.png" alt="Database Administration" />
                        </div>
                        <h5>Database Administration</h5>
                        <a href="#." class="category-jobs"><i class="fa fa-briefcase" aria-hidden="true"></i> (1)
                            Jobs</a>
                    </div>
                </div>
            </div>
            <div class="category-viewall text-center">
                <a href="#." class="btn btn-primary">View All Categories</a>
            </div>
        </div>
    </section>
    <!-- Categories end -->

    <!-- Industries start -->
    <section class="section industries-section">
        <div class="container">
            <div class="titleTop text-center">
                <div class="subtitle">Explore Sectors</div>
                <h3>Popular Industries</h3>
            </div>
            <div class="industries-grid">
                <a href="#." class="industry-chip">
                    <span class="chip-icon"><i class="fa fa-industry" aria-hidden="true"></i></span>
                    Manufacturing (5)
                </a>
                <a href="#." class="industry-chip">
                    <span class="chip-icon"><i class="fa fa-female" aria-hidden="true"></i></span>
                    Fashion (2)
                </a>
                <a href="#." class="industry-chip">
                    <span class="chip-icon"><i class="fa fa-plug" aria-hidden="true"></i></span>
                    Electronics (2)
                </a>
                <a href="#." class="industry-chip">
                    <span class="chip-icon"><i class="fa fa-bullhorn" aria-hidden="true"></i></span>
                    Advertising/PR (2)
                </a>
                <a href="#." class="industry-chip">
                    <span class="chip-icon"><i class="fa fa-desktop" aria-hidden="true"></i></span>
                    Information Technology (2)
                </a>
                <a href="#." class="industry-chip">
                    <span class="chip-icon"><i class="fa fa-truck" aria-hidden="true"></i></span>
                    Courier/Logistics (1)
                </a>
                <a href="#." class="industry-chip">
                    <span class="chip-icon"><i class="fa fa-car" aria-hidden="true"></i></span>
                    Automobile (1)
                </a>
                <a href="#." class="industry-chip">
                    <span class="chip-icon"><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
                    Education/Training (1)
                </a>
                <a href="#." class="industry-chip">
                    <span class="chip-icon"><i class="fa fa-university" aria-hidden="true"></i></span>
                    Banking/Financial Services (1)
                </a>
                <a href="#." class="industry-chip">
                    <span class="chip-icon"><i class="fa fa-heartbeat" aria-hidden="true"></i></span>
                    Health &amp; Fitness (1)
                </a>
            </div>
        </div>
    </section>
    <!-- Industries end -->

    <!-- How it Works start -->
    <section class="section howit-section">
        <div class="container">
            <div class="titleTop text-center">
                <div class="subtitle">Simple Steps</div>
                <h3>How It Works</h3>
            </div>
            <div class="row g-4 justify-content-center howit-grid">
                <div class="col-12 col-md-4">
                    <div class="howit-card">
                        <div class="howit-icon">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                        <h4>Create An Account</h4>
                        <p>It's very easy to open an account and start your journey.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="howit-card">
                        <div class="howit-icon">
                            <i class="fa-solid fa-file"></i>
                        </div>
                        <h4>Complete your profile</h4>
                        <p>Share all the key details so employers can get to know you.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="howit-card">
                        <div class="howit-icon">
                            <i class="fa-solid fa-paper-plane"></i>
                        </div>
                        <h4>Apply job or hire</h4>
                        <p>
                            Apply to your preferred jobs or hire top talent effortlessly.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- How it Works Ends -->

    <!-- Featured Jobs start -->
    <div class="section">
        <div class="container">
            <!-- title start -->
            <div class="titleTop">
                <div class="subtitle">Here You Can See</div>
                <h3>Featured <span>Jobs</span></h3>
            </div>
            <!-- title end -->

            <!--Featured Job start-->
            <div class="row g-4 featured-jobs">
                @forelse($featuredJobs as $job)
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="job-card">
                            <div class="job-card-status">
                                <span class="job-card-status-icon"><i class="fa fa-briefcase" aria-hidden="true"></i></span>
                                {{ $job->employment_type }}
                            </div>
                            <h4 class="job-card-title">
                                <a href="{{ route('jobs.show', ['slug' => $job->slug]) }}">{{ $job->title }}</a>
                            </h4>
                            <div class="job-card-location">
                                <i class="fa fa-map-marker" aria-hidden="true"></i> {{ $job->location }}
                            </div>
                            <div class="job-card-footer">
                                <div class="job-card-meta">
                                    <span class="job-card-date">{{ $job->created_at->format('M d, Y') }}</span>
                                    <span class="job-card-company">{{ $job->user?->company_name ?: 'Company' }}</span>
                                </div>
                                <div class="job-card-logo">
                                    <img src="{{ $job->user?->logo_url }}" alt="{{ $job->user?->company_name ?: 'Company' }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted mb-0">No featured jobs available yet.</p>
                    </div>
                @endforelse
            </div>
            <!--Featured Job end-->

            <!--button start-->
            <div class="category-viewall text-center">
                <a href="{{ route('jobs.index') }}" class="btn btn-primary">View All Featured Jobs</a>
            </div>
            <!--button end-->
        </div>
    </div>
    <!-- Featured Jobs ends -->

    <!-- Video start -->
    <section class="section video-section-v2">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="video-content-v2">
                        <span class="video-badge-v2">Here You Can See</span>
                        <h2 class="video-title-v2">
                            Watch Our <span class="video-highlight-v2">Video</span>
                        </h2>
                        <p class="video-text-v2">
                            Aliquam vestibulum cursus felis. In iaculis iaculis sapien ac
                            condimentum. Vestibulum congue posuere lacus, id tincidunt nisi
                            porta sit amet. Suspendisse et sapien varius, pellentesque dui
                            non.
                        </p>
                        <ul class="video-features-v2">
                            <li>
                                <i class="fa fa-check-circle" aria-hidden="true"></i> Learn
                                about our platform
                            </li>
                            <li>
                                <i class="fa fa-check-circle" aria-hidden="true"></i> Discover
                                success stories
                            </li>
                            <li>
                                <i class="fa fa-check-circle" aria-hidden="true"></i> See how
                                it works
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="video-wrapper-v2">
                        <div class="video-thumbnail-v2">
                            <img src="images/video-thumbnail.jpg" alt="Video thumbnail" class="video-image-v2" />
                            <div class="video-overlay-v2"></div>
                            <button class="video-play-btn-v2" type="button" data-bs-toggle="modal"
                                data-bs-target="#videoModalV2" aria-label="Play video">
                                <div class="play-btn-circle-v2">
                                    <i class="fa fa-play" aria-hidden="true"></i>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Video end -->

    <!-- Video Modal V2 -->
    <div class="modal fade" id="videoModalV2" tabindex="-1" aria-labelledby="videoModalV2Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content video-modal-content-v2">
                <button type="button" class="btn-close video-modal-close-v2" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="video-modal-body-v2">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Video player" frameborder="0"
                            allow="
                  accelerometer;
                  autoplay;
                  clipboard-write;
                  encrypted-media;
                  gyroscope;
                  picture-in-picture;
                "
                            allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Jobs start -->
    <div class="section greybg">
        <div class="container">
            <!-- title start -->
            <div class="titleTop">
                <div class="subtitle">Here You Can See</div>
                <h3>Latest <span>Jobs</span></h3>
            </div>
            <!-- title end -->

            <div class="row g-4 latest-jobs">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="latest-job-card">
                        <div class="latest-job-header">
                            <span class="badge badge-status fulltime">Full Time</span>
                            <a href="#." class="bookmark"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                        </div>
                        <h4><a href="#.">Technical Database Engineer</a></h4>
                        <div class="latest-job-meta">
                            <span><i class="fa fa-building" aria-hidden="true"></i> Datebase
                                Management Company</span>
                            <span><i class="fa fa-map-marker" aria-hidden="true"></i> New
                                York</span>
                        </div>
                        <div class="latest-job-footer">
                            <div class="latest-job-company">
                                <img src="images/employers/emplogo1.jpg" alt="Company logo" />
                                <div>
                                    <span class="label">Posted on</span>
                                    <span class="value">Mar 07, 2025</span>
                                </div>
                            </div>
                            <a href="#." class="btn btn-outline-primary btn-sm">Apply Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="latest-job-card">
                        <div class="latest-job-header">
                            <span class="badge badge-status freelance">Freelance</span>
                            <a href="#." class="bookmark"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                        </div>
                        <h4><a href="#.">Front-end Developer</a></h4>
                        <div class="latest-job-meta">
                            <span><i class="fa fa-building" aria-hidden="true"></i> Creative
                                Studio</span>
                            <span><i class="fa fa-map-marker" aria-hidden="true"></i>
                                Boston</span>
                        </div>
                        <div class="latest-job-footer">
                            <div class="latest-job-company">
                                <img src="images/employers/emplogo11.jpg" alt="Company logo" />
                                <div>
                                    <span class="label">Posted on</span>
                                    <span class="value">Mar 05, 2025</span>
                                </div>
                            </div>
                            <a href="#." class="btn btn-outline-primary btn-sm">Apply Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="latest-job-card">
                        <div class="latest-job-header">
                            <span class="badge badge-status parttime">Part Time</span>
                            <a href="#." class="bookmark"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                        </div>
                        <h4><a href="#.">Product Designer</a></h4>
                        <div class="latest-job-meta">
                            <span><i class="fa fa-building" aria-hidden="true"></i> Bright
                                Agency</span>
                            <span><i class="fa fa-map-marker" aria-hidden="true"></i>
                                Chicago</span>
                        </div>
                        <div class="latest-job-footer">
                            <div class="latest-job-company">
                                <img src="images/employers/emplogo12.jpg" alt="Company logo" />
                                <div>
                                    <span class="label">Posted on</span>
                                    <span class="value">Mar 04, 2025</span>
                                </div>
                            </div>
                            <a href="#." class="btn btn-outline-primary btn-sm">Apply Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="latest-job-card">
                        <div class="latest-job-header">
                            <span class="badge badge-status freelance">Freelance</span>
                            <a href="#." class="bookmark"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                        </div>
                        <h4><a href="#.">Mobile Developer</a></h4>
                        <div class="latest-job-meta">
                            <span><i class="fa fa-building" aria-hidden="true"></i> Appify
                                Labs</span>
                            <span><i class="fa fa-map-marker" aria-hidden="true"></i>
                                Remote</span>
                        </div>
                        <div class="latest-job-footer">
                            <div class="latest-job-company">
                                <img src="images/employers/emplogo13.jpg" alt="Company logo" />
                                <div>
                                    <span class="label">Posted on</span>
                                    <span class="value">Mar 02, 2025</span>
                                </div>
                            </div>
                            <a href="#." class="btn btn-outline-primary btn-sm">Apply Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="latest-job-card">
                        <div class="latest-job-header">
                            <span class="badge badge-status fulltime">Full Time</span>
                            <a href="#." class="bookmark"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                        </div>
                        <h4><a href="#.">Senior UX Researcher</a></h4>
                        <div class="latest-job-meta">
                            <span><i class="fa fa-building" aria-hidden="true"></i> Insights
                                Co.</span>
                            <span><i class="fa fa-map-marker" aria-hidden="true"></i> San
                                Francisco</span>
                        </div>
                        <div class="latest-job-footer">
                            <div class="latest-job-company">
                                <img src="images/employers/emplogo14.jpg" alt="Company logo" />
                                <div>
                                    <span class="label">Posted on</span>
                                    <span class="value">Feb 28, 2025</span>
                                </div>
                            </div>
                            <a href="#." class="btn btn-outline-primary btn-sm">Apply Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="latest-job-card">
                        <div class="latest-job-header">
                            <span class="badge badge-status fulltime">Full Time</span>
                            <a href="#." class="bookmark"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                        </div>
                        <h4><a href="#.">Systems Administrator</a></h4>
                        <div class="latest-job-meta">
                            <span><i class="fa fa-building" aria-hidden="true"></i> Sphere
                                Networks</span>
                            <span><i class="fa fa-map-marker" aria-hidden="true"></i>
                                Austin</span>
                        </div>
                        <div class="latest-job-footer">
                            <div class="latest-job-company">
                                <img src="images/employers/emplogo15.jpg" alt="Company logo" />
                                <div>
                                    <span class="label">Posted on</span>
                                    <span class="value">Feb 26, 2025</span>
                                </div>
                            </div>
                            <a href="#." class="btn btn-outline-primary btn-sm">Apply Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="latest-job-card">
                        <div class="latest-job-header">
                            <span class="badge badge-status parttime">Part Time</span>
                            <a href="#." class="bookmark"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                        </div>
                        <h4><a href="#.">Social Media Strategist</a></h4>
                        <div class="latest-job-meta">
                            <span><i class="fa fa-building" aria-hidden="true"></i> Connect
                                Agency</span>
                            <span><i class="fa fa-map-marker" aria-hidden="true"></i>
                                Denver</span>
                        </div>
                        <div class="latest-job-footer">
                            <div class="latest-job-company">
                                <img src="images/employers/emplogo16.jpg" alt="Company logo" />
                                <div>
                                    <span class="label">Posted on</span>
                                    <span class="value">Feb 25, 2025</span>
                                </div>
                            </div>
                            <a href="#." class="btn btn-outline-primary btn-sm">Apply Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="latest-job-card">
                        <div class="latest-job-header">
                            <span class="badge badge-status remote">Remote</span>
                            <a href="#." class="bookmark"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                        </div>
                        <h4><a href="#.">Support Engineer</a></h4>
                        <div class="latest-job-meta">
                            <span><i class="fa fa-building" aria-hidden="true"></i> Helpline
                                Inc.</span>
                            <span><i class="fa fa-map-marker" aria-hidden="true"></i>
                                Remote</span>
                        </div>
                        <div class="latest-job-footer">
                            <div class="latest-job-company">
                                <img src="images/employers/emplogo2.jpg" alt="Company logo" />
                                <div>
                                    <span class="label">Posted on</span>
                                    <span class="value">Feb 23, 2025</span>
                                </div>
                            </div>
                            <a href="#." class="btn btn-outline-primary btn-sm">Apply Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="latest-job-card">
                        <div class="latest-job-header">
                            <span class="badge badge-status fulltime">Full Time</span>
                            <a href="#." class="bookmark"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                        </div>
                        <h4><a href="#.">Backend Engineer</a></h4>
                        <div class="latest-job-meta">
                            <span><i class="fa fa-building" aria-hidden="true"></i> Rapid
                                Systems</span>
                            <span><i class="fa fa-map-marker" aria-hidden="true"></i>
                                Phoenix</span>
                        </div>
                        <div class="latest-job-footer">
                            <div class="latest-job-company">
                                <img src="images/employers/emplogo3.jpg" alt="Company logo" />
                                <div>
                                    <span class="label">Posted on</span>
                                    <span class="value">Feb 22, 2025</span>
                                </div>
                            </div>
                            <a href="#." class="btn btn-outline-primary btn-sm">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="category-viewall text-center">
                <a href="#." class="btn btn-primary">View All Latest Jobs</a>
            </div>
        </div>
    </div>
    <!-- Latest Jobs ends -->

    <!-- Jobs by Cities start -->
    <section class="section cities-section">
        <div class="container">
            <div class="titleTop text-center">
                <div class="subtitle">Choose Your Location</div>
                <h3>Jobs by Cities</h3>
            </div>
            <div class="row g-4 cities-grid">
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="#." class="city-card">
                        <div class="city-image">
                            <img src="images/cities/atlanta.jpg" alt="Atlanta" />
                        </div>
                        <div class="city-overlay">
                            <span>Atlanta</span>
                            <span class="city-badge"><i class="fa fa-briefcase" aria-hidden="true"></i> 18
                                Jobs</span>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="#." class="city-card">
                        <div class="city-image">
                            <img src="images/cities/barrington.jpg" alt="Barrington" />
                        </div>
                        <div class="city-overlay">
                            <span>Barrington</span>
                            <span class="city-badge"><i class="fa fa-briefcase" aria-hidden="true"></i> 9
                                Jobs</span>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="#." class="city-card">
                        <div class="city-image">
                            <img src="images/cities/durant.jpg" alt="Durant" />
                        </div>
                        <div class="city-overlay">
                            <span>Durant</span>
                            <span class="city-badge"><i class="fa fa-briefcase" aria-hidden="true"></i> 12
                                Jobs</span>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="#." class="city-card">
                        <div class="city-image">
                            <img src="images/cities/bessemer.jpg" alt="Bessemer" />
                        </div>
                        <div class="city-overlay">
                            <span>Bessemer</span>
                            <span class="city-badge"><i class="fa fa-briefcase" aria-hidden="true"></i> 6
                                Jobs</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- Jobs by Cities end -->

    <!-- Testimonials start -->
    <section class="section testimonials-section">
        <div class="container">
            <div class="titleTop text-center">
                <div class="subtitle">Stories from our community</div>
                <h3>Success Stories</h3>
            </div>
            <div class="testimonials-wrap">
                <div class="testimonials-nav testimonials-prev">
                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                </div>
                <div class="testimonials-nav testimonials-next">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </div>
                <div class="owl-carousel testimonials-carousel">
                    <div class="testimonial-card">
                        <div class="testimonial-quote">
                            <i class="fa fa-quote-left" aria-hidden="true"></i>
                        </div>
                        <p>
                            "JobsPortal helped me land my dream role within weeks. The
                            process was clean, seamless, and the support team was always
                            ready to assist."
                        </p>
                        <div class="testimonial-author">
                            <img src="images/testimonials/user1.jpg" alt="Samantha Lee" />
                            <div>
                                <span class="name">Samantha Lee</span>
                                <span class="role">Product Designer, Bright Labs</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-quote">
                            <i class="fa fa-quote-left" aria-hidden="true"></i>
                        </div>
                        <p>
                            "As an employer, we found top talent faster than ever before.
                            The platform makes publishing jobs and managing applicants
                            incredibly simple."
                        </p>
                        <div class="testimonial-author">
                            <img src="images/testimonials/user2.jpg" alt="Michael Robinson" />
                            <div>
                                <span class="name">Michael Robinson</span>
                                <span class="role">HR Manager, SphereTech</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-quote">
                            <i class="fa fa-quote-left" aria-hidden="true"></i>
                        </div>
                        <p>
                            "I appreciate the curated job recommendations and the ability to
                            connect directly with companies that align with my values."
                        </p>
                        <div class="testimonial-author">
                            <img src="images/testimonials/user3.jpg" alt="Priya Patel" />
                            <div>
                                <span class="name">Priya Patel</span>
                                <span class="role">Software Engineer, Connect People</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-quote">
                            <i class="fa fa-quote-left" aria-hidden="true"></i>
                        </div>
                        <p>
                            "We scaled our hiring pipeline dramatically thanks to
                            JobsPortal’s reach and user-friendly tools."
                        </p>
                        <div class="testimonial-author">
                            <img src="images/testimonials/user4.jpg" alt="Liam Carter" />
                            <div>
                                <span class="name">Liam Carter</span>
                                <span class="role">Founder, Appify Labs</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonials End -->

    <!-- App Start -->
    <div class="appwraper">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <!--app image Start-->
                    <div class="appimg">
                        <img src="images/app-screens.png" alt="Your alt text here" />
                    </div>
                    <!--app image end-->
                </div>
                <div class="col-lg-6 col-md-6">
                    <!--app info Start-->
                    <div class="titleTop">
                        <div class="subtitle">Step Forword Now</div>
                        <h3>The JobsPortal APP</h3>
                    </div>
                    <div class="subtitle2">A world of oppertunity in your hand</div>
                    <p>
                        Aliquam vestibulum cursus felis. In iaculis iaculis sapien ac
                        condimentum. Vestibulum congue posuere lacus, id tincidunt nisi
                        porta sit amet. Suspendisse et sapien varius, pellentesque dui
                        non, semper orci. Curabitur blandit, diam ut ornare ultricies.
                    </p>
                    <div class="appbtn">
                        <a href="#."><img src="images/apple-btn.png" alt="Your alt text here" /></a>
                        <a href="#."><img src="images/andriod-btn.png" alt="Your alt text here" /></a>
                    </div>
                    <!--app info end-->
                </div>
            </div>
        </div>
    </div>
    <!-- App End -->

    <!-- Subscribe -->
    <section class="section subscribe-section">
        <div class="container">
            <div class="subscribe-wrapper">
                <div class="subscribe-copy">
                    <span class="subscribe-badge">Stay in the loop</span>
                    <h3>Subscribe To Our Newsletter</h3>
                    <p>
                        Get the latest jobs, hiring trends, and tips delivered directly to
                        your inbox.
                    </p>
                </div>
                <form class="subscribe-form">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                        <input type="email" class="form-control" placeholder="Enter your email" required />
                        <button class="btn btn-primary" type="submit">Subscribe</button>
                    </div>
                    <small class="subscribe-note">We respect your privacy. Unsubscribe anytime.</small>
                </form>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="titleTop text-center">
                <div class="subtitle">Our Blog</div>
                <h3>Latest Blog Posts</h3>
            </div>

            <div class="blog-grid">
                <article class="blog-card">
                    <div class="blog-card-media">
                        <img src="images/blog/1.jpg" alt="Blog cover" />
                        <span class="blog-card-tag">Hiring</span>
                    </div>
                    <div class="blog-card-body">
                        <div class="blog-card-meta">
                            <span>17 Sep</span>
                            <span>•</span>
                            <span>7 min read</span>
                        </div>
                        <h3>
                            <a href="blog-detail.html">How to design a candidate experience that actually
                                converts</a>
                        </h3>
                        <p>
                            From first touch to offer, here’s the messaging stack and
                            automation playbook we use to keep talent engaged.
                        </p>
                        <div class="blog-card-footer">
                            <div class="author">
                                <img src="images/coment-avatar-1.jpg" alt="Author" />
                                <div>
                                    <strong>Samira Hodge</strong>
                                    <span>Employer Brand Lead</span>
                                </div>
                            </div>
                            <a href="blog-detail.html" class="text-link">Read article <i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </article>

                <article class="blog-card">
                    <div class="blog-card-media">
                        <img src="images/blog/2.jpg" alt="Blog cover" />
                        <span class="blog-card-tag teal">Leadership</span>
                    </div>
                    <div class="blog-card-body">
                        <div class="blog-card-meta">
                            <span>15 Sep</span>
                            <span>•</span>
                            <span>5 min read</span>
                        </div>
                        <h3>
                            <a href="blog-detail.html">7 rituals our leadership team uses to stay aligned
                                remotely</a>
                        </h3>
                        <p>
                            Weekly dashboards, async standups, and lightweight rituals that
                            keep strategic bets on track.
                        </p>
                        <div class="blog-card-footer">
                            <div class="author">
                                <img src="images/coment-avatar-2.jpg" alt="Author" />
                                <div>
                                    <strong>Devon Marks</strong>
                                    <span>Chief of Staff</span>
                                </div>
                            </div>
                            <a href="blog-detail.html" class="text-link">Read article <i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </article>

                <article class="blog-card">
                    <div class="blog-card-media">
                        <img src="images/blog/3.jpg" alt="Blog cover" />
                        <span class="blog-card-tag orange">Culture</span>
                    </div>
                    <div class="blog-card-body">
                        <div class="blog-card-meta">
                            <span>12 Sep</span>
                            <span>•</span>
                            <span>6 min read</span>
                        </div>
                        <h3>
                            <a href="blog-detail.html">Inside the onboarding sprint that ramps new hires in 10
                                days</a>
                        </h3>
                        <p>
                            A look at how we bundle product education, values training, and
                            buddy systems into a cohesive journey.
                        </p>
                        <div class="blog-card-footer">
                            <div class="author">
                                <img src="images/coment-avatar-3.jpg" alt="Author" />
                                <div>
                                    <strong>Lily Ortega</strong>
                                    <span>People Programs</span>
                                </div>
                            </div>
                            <a href="blog-detail.html" class="text-link">Read article <i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>


@endsection
