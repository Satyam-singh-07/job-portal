@extends('layouts.app')

@section('title', 'Job Applications')

@section('content')
<div class="employer-hero">
    <div class="container">
        <div class="employer-hero-content">
            <div>
                <span class="company-pill">{{ auth()->user()->company_name }}</span>
                <h1>Applications for {{ $job->title }}</h1>
                <p>Review applicants, track progress, and update hiring pipeline statuses.</p>
            </div>
            <a href="{{ route('employer.manage-jobs') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Back to Manage Jobs
            </a>
        </div>
    </div>
</div>

<section class="dashboard-section employer-dashboard">
    <div class="container mt-4">
        <div class="dashboard-layout">
            @include('employers.partials.sidebar')

            <div class="dashboard-main">
                <div class="stats-grid mb-4">
                    <div class="stat-card">
                        <div class="stat-icon bg-primary-subtle"><i class="fas fa-users"></i></div>
                        <div class="stat-content">
                            <span class="stat-label" style="color: black">Total Applications</span>
                            <span class="stat-value" style="color: black">{{ $totalApplications }}</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon bg-warning-subtle"><i class="fas fa-clock"></i></div>
                        <div class="stat-content">
                            <span class="stat-label" style="color: black">Pending</span>
                            <span class="stat-value" style="color: black">{{ $statusStats['Pending'] ?? 0 }}</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon bg-info-subtle"><i class="fas fa-user-check"></i></div>
                        <div class="stat-content">
                            <span class="stat-label" style="color: black">Interviewing</span>
                            <span class="stat-value" style="color: black">{{ $statusStats['Interviewing'] ?? 0 }}</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon bg-success-subtle"><i class="fas fa-handshake"></i></div>
                        <div class="stat-content">
                            <span class="stat-label" style="color: black">Accepted</span>
                            <span class="stat-value" style="color: black">{{ $statusStats['Accepted'] ?? 0 }}</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon bg-success-subtle"><i class="fas fa-robot"></i></div>
                        <div class="stat-content">
                            <span class="stat-label" style="color: black">Top AI Match</span>
                            <span class="stat-value" style="color: black">{{ (int) ($topMatchScore ?? 0) }}%</span>
                        </div>
                    </div>
                </div>

                <div class="jobs-filters-panel">
                    <form method="GET" class="filter-header">
                        <h3>Applicant List (AI top match first)</h3>
                        <div class="filter-actions">
                            <select class="filter-select" name="status" onchange="this.form.submit()">
                                <option value="">All Statuses</option>
                                @foreach($allowedStatuses as $status)
                                    <option value="{{ $status }}" {{ $statusFilter === $status ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" name="search" value="{{ $search }}" placeholder="Search by name/email...">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                        </div>
                    </form>
                </div>

                <div class="jobs-list-panel">
                    @forelse($applications as $application)
                        @php
                            $candidate = $application->user;
                            $profile = $candidate?->candidateProfile;
                            $resumePath = $application->resume_path ?: $profile?->resume;
                        @endphp

                        <div class="job-management-card" data-application-id="{{ $application->id }}">
                            <div class="job-card-header">
                                <div class="job-title-section">
                                    <h4>{{ trim(($candidate?->first_name ?? '').' '.($candidate?->last_name ?? '')) ?: 'Candidate' }}</h4>
                                    <span class="job-id">#APP-{{ $application->id }}</span>
                                </div>

                                <div class="job-status-actions">
                                    <span class="job-status status-{{ strtolower($application->status) }} application-status-chip" data-status-chip>
                                        {{ $application->status }}
                                    </span>
                                    <span
                                        class="job-status"
                                        style="background: {{ (int) $application->ai_match_score >= 75 ? '#d1e7dd' : ((int) $application->ai_match_score >= 45 ? '#fff3cd' : '#f8d7da') }}; color: #111;"
                                        title="{{ implode(', ', $application->ai_match_highlights ?? []) }}"
                                    >
                                        AI {{ (int) $application->ai_match_score }}%
                                    </span>
                                    <select class="filter-select application-status-select" data-status-select data-url="{{ route('employer.jobs.applications.status', [$job->id, $application->id]) }}">
                                        @foreach($allowedStatuses as $status)
                                            <option value="{{ $status }}" {{ $application->status === $status ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="job-card-body">
                                <div class="job-meta-grid">
                                    <div class="meta-item"><i class="fas fa-envelope"></i><span>{{ $candidate?->email }}</span></div>
                                    <div class="meta-item"><i class="fas fa-phone"></i><span>{{ $profile?->phone ?: 'Not provided' }}</span></div>
                                    <div class="meta-item"><i class="fas fa-map-marker-alt"></i><span>{{ $profile?->location ?: 'Not provided' }}</span></div>
                                    <div class="meta-item"><i class="fas fa-briefcase"></i><span>{{ $profile?->title ?: 'Not specified' }}</span></div>
                                    <div class="meta-item"><i class="fas fa-calendar"></i><span>Applied {{ $application->created_at->diffForHumans() }}</span></div>
                                    <div class="meta-item"><i class="fas fa-eye"></i><span>Resume views {{ $application->resume_views_count ?? 0 }}</span></div>
                                </div>

                                @if($application->cover_letter)
                                    <div class="application-cover-note">
                                        <strong>Cover Letter:</strong>
                                        <p class="mb-0 mt-1">{{ \Illuminate\Support\Str::limit($application->cover_letter, 240) }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="job-card-footer">
                                <div class="quick-actions d-flex gap-2 flex-wrap">
                                    @if($resumePath)
                                        <a href="{{ route('employer.jobs.applications.resume', [$job->id, $application->id]) }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-file-download"></i> View Resume
                                        </a>
                                    @else
                                        <button class="btn btn-outline-secondary btn-sm" disabled>
                                            <i class="fas fa-file-circle-xmark"></i> Resume Not Available
                                        </button>
                                    @endif
                                </div>
                                <span class="last-updated">
                                    <i class="fas fa-clock"></i> Updated {{ $application->updated_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="fas fa-users"></i></div>
                            <h3>No applications found</h3>
                            <p>No candidates match the current filters for this job.</p>
                        </div>
                    @endforelse
                </div>

                @if($applications->hasPages())
                    <div class="pagination-wrapper mt-3">
                        {{ $applications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
.application-cover-note {
    background: #f8f9fa;
    border-radius: 0.5rem;
    padding: 0.75rem;
    margin-top: 0.75rem;
}

.job-status.status-pending { background: #fff3cd; color: #856404; }
.job-status.status-reviewed { background: #cff4fc; color: #055160; }
.job-status.status-interviewing { background: #d1e7dd; color: #0f5132; }
.job-status.status-offered { background: #e2d9f3; color: #4b2e83; }
.job-status.status-rejected { background: #f8d7da; color: #842029; }
.job-status.status-accepted { background: #d1e7dd; color: #0f5132; }

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

@section('scripts')
<script>
(function () {
    function showToast(message, type = 'success') {
        const toastEl = document.getElementById('liveToast');
        if (!toastEl) return;

        toastEl.classList.remove('bg-success', 'bg-danger');
        toastEl.classList.add(type === 'success' ? 'bg-success' : 'bg-danger');

        const body = toastEl.querySelector('.toast-body');
        if (body) body.innerText = message;

        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    }

    function statusToClass(status) {
        return `status-${String(status || '').toLowerCase()}`;
    }

    document.querySelectorAll('[data-status-select]').forEach((selectEl) => {
        selectEl.addEventListener('change', async function () {
            const url = this.getAttribute('data-url');
            const status = this.value;
            const card = this.closest('[data-application-id]');
            const chip = card?.querySelector('[data-status-chip]');
            const previousStatus = chip ? chip.innerText.trim() : '';
            const previousClass = previousStatus ? statusToClass(previousStatus) : '';

            this.disabled = true;

            try {
                const response = await fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status })
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(data?.message || 'Unable to update status.');
                }

                if (chip) {
                    if (previousClass) chip.classList.remove(previousClass);
                    chip.classList.add(statusToClass(status));
                    chip.innerText = status;
                }

                showToast(data.message || 'Status updated successfully.');
            } catch (error) {
                if (previousStatus) {
                    this.value = previousStatus;
                }
                showToast(error.message || 'Unable to update status right now.', 'error');
            } finally {
                this.disabled = false;
            }
        });
    });
})();
</script>
@endsection
