@extends('layouts.app')

@section('title', ($employer->company_name ?: 'Company').' Detail')

@section('content')
<section class="company-hero">
    <div class="company-hero-cover" style="background-image: url('{{ asset('images/employers/cover-photo.jpg') }}');"></div>
    <div class="container">
        <div class="company-hero-wrapper">
            <div class="company-hero-meta">
                <div class="company-hero-logo">
                    <img src="{{ $employer->logo_url }}" alt="{{ $employer->company_name ?: 'Company' }}" />
                </div>
                <div>
                    <span class="company-hero-label">{{ $employer->industry ?: 'Hiring Company' }}</span>
                    <h1 class="company-hero-title">{{ $employer->company_name ?: $employer->username }}</h1>
                    <div class="company-hero-tags">
                        <span><i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                            {{ $openJobs->first()?->location ?: 'Location not specified' }}</span>
                        <span><i class="fa-solid fa-users" aria-hidden="true"></i>
                            {{ $employer->team_size ?: 'Team size not specified' }}</span>
                        <span><i class="fa-solid fa-user-check" aria-hidden="true"></i>
                            {{ $totalApplicants }} Applicants</span>
                    </div>
                </div>
            </div>
            <div class="company-hero-actions">
                <a href="#openings" class="btn btn-primary"><i class="fa-solid fa-briefcase" aria-hidden="true"></i>
                    View Open Roles</a>
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
                    <p>{{ $employer->summary ?: 'We are building high-impact teams and hiring top talent across roles.' }}</p>
                </section>

                <section id="openings" class="company-openings-section mt-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                        <div>
                            <h2 class="company-detail-heading mb-1">Open Roles</h2>
                            <p class="company-detail-subtitle mb-0">
                                {{ $openJobs->count() }} active openings · {{ $totalApplicants }} total applicants
                            </p>
                        </div>
                        <a href="{{ route('jobs.index', ['search' => $employer->company_name]) }}" class="btn btn-outline-primary">
                            <i class="fa-solid fa-magnifying-glass"></i> Explore More Jobs
                        </a>
                    </div>

                    @if($openJobs->count() > 0)
                        <div class="row g-4 job-grid">
                            @foreach($openJobs as $job)
                                <div class="col-md-6 col-xl-4">
                                    <div class="job-board-card">
                                        <div class="job-card-status">
                                            <span class="job-type {{ strtolower($job->employment_type ?: 'fulltime') }}">
                                                {{ $job->employment_type ?: 'N/A' }}
                                            </span>
                                        </div>
                                        <h4><a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a></h4>
                                        <div class="job-salary">
                                            Salary: <strong>{{ $job->salary_range ?: 'Not disclosed' }}</strong>
                                        </div>
                                        <div class="job-location">
                                            <i class="fa-solid fa-location-dot"></i> {{ $job->location ?: 'Location not specified' }}
                                        </div>
                                        <div class="job-card-footer">
                                            <div class="job-card-company">
                                                <img src="{{ $employer->logo_url }}" alt="{{ $employer->company_name ?: 'Company' }}" />
                                                <div>
                                                    <span class="label">Applicants</span>
                                                    <span class="value">{{ $job->applications_count }}</span>
                                                </div>
                                            </div>
                                            <div>
                                                <span class="label">Views</span>
                                                <span class="value">{{ $job->views_count }}</span>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <span class="label">Posted</span>
                                            <span class="value">{{ $job->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="company-detail-section">
                            <p class="mb-0 text-muted">No open roles right now.</p>
                        </div>
                    @endif
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
                                    @if($employer->website)
                                        <a href="{{ $employer->website }}" target="_blank" rel="noopener noreferrer">{{ parse_url($employer->website, PHP_URL_HOST) ?: $employer->website }}</a>
                                    @else
                                        <span>Not provided</span>
                                    @endif
                                </dd>
                            </div>
                            <div class="fact-item">
                                <dt><i class="fa-solid fa-industry"></i> Industry</dt>
                                <dd>{{ $employer->industry ?: 'Not specified' }}</dd>
                            </div>
                            <div class="fact-item">
                                <dt><i class="fa-solid fa-layer-group"></i> Open Jobs</dt>
                                <dd>{{ $openJobs->count() }}</dd>
                            </div>
                            <div class="fact-item">
                                <dt><i class="fa-solid fa-user-check"></i> Total Applicants</dt>
                                <dd>{{ $totalApplicants }}</dd>
                            </div>
                        </dl>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
@endsection
