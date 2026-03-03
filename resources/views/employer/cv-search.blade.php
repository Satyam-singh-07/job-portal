@extends('layouts.app')

@section('title', 'CV Search')

@section('content')
<section class="dashboard-section employer-dashboard">
    <div class="container mt-4">
        <div class="dashboard-layout">
            @include('employers.partials.sidebar')

            <div class="dashboard-main">
                <div class="dashboard-page-header">
                    <div>
                        <h1>CV Search</h1>
                        <p>Search open-to-work candidates with enterprise filters and direct outreach.</p>
                    </div>
                </div>

                <div class="stats-grid mb-4">
                    <div class="stat-card">
                        <div class="stat-content">
                            <span class="stat-label" style="color:black;">Searchable Candidates</span>
                            <span class="stat-value" style="color:black;">{{ number_format($stats['searchable_candidates']) }}</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-content">
                            <span class="stat-label" style="color:black;">Candidates with Resume</span>
                            <span class="stat-value" style="color:black;">{{ number_format($stats['with_resume']) }}</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-content">
                            <span class="stat-label" style="color:black;">Active in Last 30 Days</span>
                            <span class="stat-value" style="color:black;">{{ number_format($stats['new_last_30_days']) }}</span>
                        </div>
                    </div>
                </div>

                <div class="jobs-filters-panel">
                    <form method="GET" class="row g-3">
                        <div class="col-md-6 col-lg-4">
                            <label class="form-label">Keyword</label>
                            <input type="text" name="q" class="form-control" value="{{ $filters['q'] }}" placeholder="Name, title, skills, target role...">
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label class="form-label">Location</label>
                            <select name="location" class="form-select">
                                <option value="">All Locations</option>
                                @foreach($filterOptions['locations'] as $location)
                                    <option value="{{ $location }}" {{ $filters['location'] === $location ? 'selected' : '' }}>{{ $location }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label class="form-label">Experience Level</label>
                            <select name="experience_level" class="form-select">
                                <option value="">All Levels</option>
                                @foreach($filterOptions['experience_levels'] as $level)
                                    <option value="{{ $level }}" {{ $filters['experience_level'] === $level ? 'selected' : '' }}>{{ $level }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">Work Preference</label>
                            <select name="work_preference" class="form-select">
                                <option value="">All</option>
                                @foreach($filterOptions['work_preferences'] as $workPreference)
                                    <option value="{{ $workPreference }}" {{ $filters['work_preference'] === $workPreference ? 'selected' : '' }}>{{ $workPreference }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">Employment Type</label>
                            <select name="desired_employment_type" class="form-select">
                                <option value="">All</option>
                                @foreach($filterOptions['employment_types'] as $employmentType)
                                    <option value="{{ $employmentType }}" {{ $filters['desired_employment_type'] === $employmentType ? 'selected' : '' }}>{{ $employmentType }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 col-lg-2">
                            <label class="form-label">Resume</label>
                            <select name="has_resume" class="form-select">
                                <option value="">Any</option>
                                <option value="1" {{ (string) $filters['has_resume'] === '1' ? 'selected' : '' }}>Has Resume</option>
                                <option value="0" {{ (string) $filters['has_resume'] === '0' ? 'selected' : '' }}>No Resume</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-lg-2">
                            <label class="form-label">Sort</label>
                            <select name="sort" class="form-select">
                                <option value="recent" {{ $filters['sort'] === 'recent' ? 'selected' : '' }}>Most Recent</option>
                                <option value="oldest" {{ $filters['sort'] === 'oldest' ? 'selected' : '' }}>Oldest</option>
                                <option value="name_asc" {{ $filters['sort'] === 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                                <option value="name_desc" {{ $filters['sort'] === 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                            </select>
                        </div>
                        <div class="col-md-12 col-lg-2 d-flex align-items-end gap-2">
                            <button class="btn btn-primary w-100" type="submit">Search</button>
                            <a href="{{ route('employer.cv-search') }}" class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                    </form>
                </div>

                <div class="jobs-list-panel">
                    <div class="mb-3">
                        <h3 class="mb-0">{{ number_format($candidates->total()) }} Candidate{{ $candidates->total() === 1 ? '' : 's' }} Found</h3>
                    </div>

                    @forelse($candidates as $profile)
                        @php
                            $candidate = $profile->user;
                            $candidateName = trim(($candidate?->first_name ?? '').' '.($candidate?->last_name ?? ''));
                            $candidateName = $candidateName !== '' ? $candidateName : ($candidate?->username ?: 'Candidate');
                            $skills = is_array($profile->skills) ? array_slice($profile->skills, 0, 5) : [];
                            $resumeUrl = $profile->resume ? \Illuminate\Support\Facades\Storage::url($profile->resume) : null;
                        @endphp
                        <div class="job-management-card">
                            <div class="job-card-header">
                                <div class="job-title-section">
                                    <h4>{{ $candidateName }}</h4>
                                    <span class="job-id">{{ $profile->title ?: 'Candidate Profile' }}</span>
                                </div>
                                <div class="job-status-actions">
                                    <span class="job-status status-reviewed">Open to Work</span>
                                </div>
                            </div>

                            <div class="job-card-body">
                                <div class="job-meta-grid">
                                    <div class="meta-item"><i class="fas fa-envelope"></i><span>{{ $candidate?->email }}</span></div>
                                    <div class="meta-item"><i class="fas fa-phone"></i><span>{{ $profile->phone ?: 'Not provided' }}</span></div>
                                    <div class="meta-item"><i class="fas fa-map-marker-alt"></i><span>{{ $profile->location ?: 'Not provided' }}</span></div>
                                    <div class="meta-item"><i class="fas fa-briefcase"></i><span>{{ $profile->experience_level ?: 'Not specified' }}</span></div>
                                    <div class="meta-item"><i class="fas fa-laptop-house"></i><span>{{ $profile->work_preference ?: 'Not specified' }}</span></div>
                                    <div class="meta-item"><i class="fas fa-clock"></i><span>Updated {{ $profile->updated_at->diffForHumans() }}</span></div>
                                </div>

                                @if(!empty($skills))
                                    <div class="application-cover-note mt-2">
                                        <strong>Top Skills:</strong>
                                        <div class="d-flex flex-wrap gap-2 mt-2">
                                            @foreach($skills as $skill)
                                                <span class="badge text-bg-light border">{{ $skill }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="job-card-footer">
                                <div class="quick-actions d-flex gap-2 flex-wrap">
                                    @if($resumeUrl)
                                        <a href="{{ $resumeUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-file-download"></i> View Resume
                                        </a>
                                    @else
                                        <button class="btn btn-outline-secondary btn-sm" disabled>No Resume</button>
                                    @endif

                                    <form action="{{ route('employer.messages.start-candidate', $candidate->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="body" value="Hi {{ $candidateName }}, we found your profile in CV Search and would like to connect regarding suitable roles.">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-paper-plane"></i> Message Candidate
                                        </button>
                                    </form>
                                </div>
                                <span class="last-updated">
                                    {{ $profile->desired_employment_type ?: 'Employment type not set' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="fas fa-users"></i></div>
                            <h3>No candidates match your filters</h3>
                            <p>Try broadening the search criteria.</p>
                        </div>
                    @endforelse
                </div>

                @if($candidates->hasPages())
                    <div class="pagination-wrapper mt-3">
                        {{ $candidates->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection


@section('styles')
<style>
/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    transition: transform 0.2s;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.bg-primary-subtle {
    background: rgba(13, 110, 253, 0.1);
    color: #0d6efd;
}

.bg-success-subtle {
    background: rgba(25, 135, 84, 0.1);
    color: #198754;
}

.bg-warning-subtle {
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.bg-info-subtle {
    background: rgba(13, 202, 240, 0.1);
    color: #0dcaf0;
}

.stat-content {
    flex: 1;
}

.stat-label {
    display: block;
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
}

.stat-value {
    display: block;
    font-size: 1.75rem;
    font-weight: 600;
    color: #212529;
    line-height: 1.2;
}


/* Filters Panel */
.jobs-filters-panel {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.filter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.filter-header h3 {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
}

.filter-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.filter-select {
    padding: 0.5rem 2rem 0.5rem 1rem;
    border: 1px solid #dee2e6;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    background: white;
    cursor: pointer;
}

.search-box {
    position: relative;
}

.search-box i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 0.875rem;
}

.search-box input {
    padding: 0.5rem 1rem 0.5rem 2.5rem;
    border: 1px solid #dee2e6;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    width: 250px;
}

.search-box input:focus {
    outline: none;
    border-color: #0d6efd;
    box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
}

/* Job Cards */
.job-management-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    transition: all 0.2s;
    border: 1px solid transparent;
}

.job-management-card:hover {
    border-color: #0d6efd;
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.1);
}

.job-card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.job-title-section {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.job-title-section h4 {
    font-size: 1.125rem;
    font-weight: 600;
    margin: 0;
}

.job-id {
    font-size: 0.75rem;
    color: #6c757d;
    background: #f8f9fa;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
}

.job-status-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.job-status {
    padding: 0.35rem 0.75rem;
    border-radius: 2rem;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.job-status.status-published {
    background: #d1e7dd;
    color: #0f5132;
}

.job-status.status-draft {
    background: #fff3cd;
    color: #856404;
}

.job-status.status-closed {
    background: #e2e3e5;
    color: #41464b;
}

.action-buttons {
    position: relative;
}

.btn-icon {
    background: transparent;
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #6c757d;
    transition: all 0.2s;
}

.btn-icon:hover {
    background: #f8f9fa;
    color: #0d6efd;
}

.job-action-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    padding: 0.5rem;
    min-width: 200px;
    display: none;
    z-index: 100;
}

.job-action-menu.show {
    display: block;
}

.menu-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    width: 100%;
    border: none;
    background: transparent;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    color: #212529;
    cursor: pointer;
    transition: all 0.2s;
}

.menu-item:hover {
    background: #f8f9fa;
}

.menu-item.text-danger:hover {
    background: #f8d7da;
    color: #dc3545;
}

.menu-divider {
    margin: 0.5rem 0;
    border: none;
    border-top: 1px solid #5a5b5c;
}

/* Job Meta Grid */
.job-meta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1rem;
    margin-bottom: 1rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #6c757d;
}

.meta-item i {
    width: 16px;
    color: #0d6efd;
}

/* Job Stats Row */
.job-stats-row {
    display: flex;
    align-items: center;
    gap: 2rem;
    padding: 1rem 0;
    border-top: 1px solid #dee2e6;
    border-bottom: 1px solid #dee2e6;
}

.stat-badge {
    display: flex;
    align-items: baseline;
    gap: 0.5rem;
}

.badge-count {
    font-size: 1.125rem;
    font-weight: 600;
    color: #212529;
}

.badge-label {
    font-size: 0.875rem;
    color: #6c757d;
}

.progress-indicator {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.progress-indicator span {
    font-size: 0.875rem;
    color: #6c757d;
    white-space: nowrap;
}

.progress {
    flex: 1;
    height: 8px;
    background: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: #0d6efd;
    border-radius: 4px;
}

/* Job Card Footer */
.job-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1rem;
}

.quick-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.8125rem;
}

.last-updated {
    font-size: 0.75rem;
    color: #6c757d;
}

.last-updated i {
    margin-right: 0.25rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem;
    background: white;
    border-radius: 1rem;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    background: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: #0d6efd;
}

.empty-state h3 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #6c757d;
    margin-bottom: 1.5rem;
}

/* Pagination */
.pagination-wrapper {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
}

/* Responsive */
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }

    .filter-header {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-actions {
        flex-direction: column;
    }

    .search-box input {
        width: 100%;
    }

    .job-meta-grid {
        grid-template-columns: 1fr;
    }

    .job-stats-row {
        flex-wrap: wrap;
        gap: 1rem;
    }

    .progress-indicator {
        width: 100%;
    }

    .job-card-footer {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
}
</style>
@endsection
