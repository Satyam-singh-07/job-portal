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
                            <span>Resume Views</span>
                            <strong>{{ number_format($stats['profile_views']) }}</strong>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card stat-orange">
                            <span>Followings</span>
                            <strong>{{ number_format($stats['followings']) }}</strong>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card stat-blue">
                            <span>Resume Versions</span>
                            <strong>{{ number_format($stats['resume_versions']) }}</strong>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card stat-teal">
                            <span>Unread Messages</span>
                            <strong>{{ number_format($stats['unread_messages']) }}</strong>
                        </div>
                    </div>
                </div>

                <div class="dashboard-panel" style="margin-top: 1rem;">
                    <div class="panel-heading">
                        <h3>Application Balance</h3>
                        <a href="{{ route('candidate.applications') }}">Manage Applications</a>
                    </div>
                    <div class="package-grid">
                        <div class="package-chip {{ ($stats['application_balance'] ?? 0) <= 2 ? 'danger' : '' }}">
                            <span class="label">Remaining Apply Credits</span>
                            <strong>{{ number_format((int) ($stats['application_balance'] ?? 0)) }}</strong>
                        </div>
                    </div>
                </div>

                <div class="dashboard-cover-card">
                    <div class="dashboard-cover-media">
                        <img src="{{ asset('images/hero-bg.jpg') }}" alt="Career dashboard" />
                    </div>
                    <div class="dashboard-cover-profile">
                        <div class="cover-avatar">
                            <img src="{{ asset('images/candidates/01.jpg') }}" alt="Candidate avatar" />
                        </div>
                        <div>
                            <h3>{{ trim((auth()->user()->first_name ?? '').' '.(auth()->user()->last_name ?? '')) ?: (auth()->user()->username ?: 'Candidate') }}</h3>
                            <p>{{ $profile->title ?: 'Candidate Profile' }} · {{ $profile->location ?: 'Location not specified' }}</p>
                            <ul>
                                <li><i class="fa-solid fa-phone"></i> {{ $profile->phone ?: 'Phone not added' }}</li>
                                <li><i class="fa-solid fa-envelope"></i> {{ auth()->user()->email }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <section class="dashboard-panel">
                    <div class="panel-heading">
                        <h3>Application Pipeline</h3>
                        <a href="{{ route('candidate.applications') }}">View All</a>
                    </div>
                    <div class="package-grid">
                        <div class="package-chip">
                            <span class="label">Total Applications</span>
                            <strong>{{ $stats['applications_total'] }}</strong>
                        </div>
                        <div class="package-chip">
                            <span class="label">Pending</span>
                            <strong>{{ $stats['applications_pending'] }}</strong>
                        </div>
                        <div class="package-chip">
                            <span class="label">Interviewing</span>
                            <strong>{{ $stats['applications_interviewing'] }}</strong>
                        </div>
                        <div class="package-chip {{ $stats['applications_offered'] > 0 ? '' : 'danger' }}">
                            <span class="label">Offers</span>
                            <strong>{{ $stats['applications_offered'] }}</strong>
                        </div>
                    </div>
                </section>

                <section class="dashboard-panel">
                    <div class="panel-heading">
                        <h3>Recent Applications</h3>
                        <a href="{{ route('candidate.applications') }}">View All</a>
                    </div>
                    <div class="row g-3">
                        @forelse($recentApplications as $application)
                            <div class="col-md-4">
                                <div class="applied-card">
                                    <span class="badge-status {{ in_array($application->status, ['Rejected', 'Withdrawn'], true) ? 'danger' : '' }}">
                                        {{ $application->status }}
                                    </span>
                                    <h4>{{ $application->job->title }}</h4>
                                    <p>{{ $application->job->location }}</p>
                                    <div class="applied-meta">
                                        <span>Salary: {{ $application->job->salary_range ?: 'Not disclosed' }}</span>
                                        <span>Applied: {{ $application->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="applied-footer">
                                        <div>
                                            <strong>{{ $application->job->user->company_name ?: 'Company' }}</strong>
                                        </div>
                                        <img src="{{ $application->job->user->logo_url }}" alt="{{ $application->job->user->company_name ?: 'Company' }}" />
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="empty-state text-center py-4 bg-white rounded-4 shadow-sm">
                                    <h4 class="mb-2">No applications yet</h4>
                                    <p class="mb-3 text-muted">Start applying to track your pipeline here.</p>
                                    <a href="{{ route('jobs.index') }}" class="btn btn-primary">Browse Jobs</a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </section>

                <section class="dashboard-panel">
                    <div class="panel-heading">
                        <h3>Recommended Jobs</h3>
                        <a href="{{ route('jobs.index') }}">View All</a>
                    </div>
                    <div class="row g-3">
                        @forelse($recommendedJobs as $job)
                            <div class="col-md-4">
                                <div class="recommended-card">
                                    <span class="badge-status {{ strtolower(str_contains($job->employment_type, 'contract') ? 'danger' : '') }}">
                                        {{ $job->employment_type }}
                                    </span>
                                    <h4><a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a></h4>
                                    <p>{{ $job->location }} · {{ $job->user->company_name ?: 'Company' }}</p>
                                    <div class="recommended-meta">
                                        <span>Salary: {{ $job->salary_range ?: 'Not disclosed' }}</span>
                                        <span>{{ $job->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="empty-state text-center py-4 bg-white rounded-4 shadow-sm">
                                    <h4 class="mb-2">No recommendations yet</h4>
                                    <p class="mb-0 text-muted">Update your profile to improve job recommendations.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </section>

                <section class="dashboard-panel">
                    <div class="panel-heading">
                        <h3>My Followings</h3>
                        <a href="{{ route('candidate.followings') }}">View All</a>
                    </div>
                    <div class="row g-3">
                        @forelse($followingsPreview as $employer)
                            <div class="col-md-4">
                                <div class="following-card">
                                    <h4>{{ $employer->company_name ?: 'Company' }}</h4>
                                    <p>{{ $employer->industry ?: 'Hiring in multiple industries' }}</p>
                                    <span>{{ $employer->open_jobs_count ?? 0 }} Open {{ ($employer->open_jobs_count ?? 0) === 1 ? 'Job' : 'Jobs' }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="empty-state text-center py-4 bg-white rounded-4 shadow-sm">
                                    <h4 class="mb-2">No followings yet</h4>
                                    <p class="mb-3 text-muted">Follow employers to get faster updates.</p>
                                    <a href="{{ route('jobs.index') }}" class="btn btn-outline-primary">Discover Companies</a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
@endsection
