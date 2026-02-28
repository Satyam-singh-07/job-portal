@extends('layouts.app')

@section('title', 'Manage Jobs')

@section('content')

    <div class="employer-hero">
        <div class="container">
            <div class="employer-hero-content">
                <div>
                    <span class="company-pill">{{ auth()->user()->company_name }}</span>
                    <h1>Manage your job listings</h1>
                    <p>
                        View, edit, and track all your job postings in one place. 
                        Monitor applications and update job status.
                    </p>
                </div>
                <a href="{{ route('employer.post-job') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Post New Job
                </a>
            </div>
        </div>
    </div>

    <section class="dashboard-section employer-dashboard">
        <div class="container mt-4">
            <div class="dashboard-layout">
                
                @include('employers.partials.sidebar')

                <div class="dashboard-main">
                    
                    <!-- Job Stats Cards -->
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon bg-primary-subtle">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-label" style="color: black">Active Jobs</span>
                                <span class="stat-value" style="color: black">{{ $activeJobsCount }}</span>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon bg-success-subtle">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-label" style="color: black">Total Applications</span>
                                <span class="stat-value" style="color: black">{{ $total_applications }}</span>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon bg-warning-subtle">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-label" style="color: black">Pending Reviews</span>
                                <span class="stat-value" style="color: black">{{ $pending_reviews }}</span>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon bg-info-subtle">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-label" style="color: black">Drafts</span>
                                <span class="stat-value" style="color: black">{{ $draftJobsCount }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Filters and Search -->
                    <div class="jobs-filters-panel">
                        <div class="filter-header">
                            <h3>Your Job Postings</h3>
                            <div class="filter-actions">
                                <select class="filter-select" id="statusFilter">
                                    <option value="all">All Status</option>
                                    <option value="Published">Published</option>
                                    <option value="Draft">Draft</option>
                                    <option value="Closed">Closed</option>
                                </select>
                                <div class="search-box">
                                    <i class="fas fa-search"></i>
                                    <input type="text" id="jobSearch" placeholder="Search jobs...">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jobs List -->
                    <div class="jobs-list-panel">
                        @if(isset($jobs) && $jobs->count() > 0)
                            @foreach($jobs as $job)
                                <div class="job-management-card" data-job-id="{{ $job->id }}">
                                    <div class="job-card-header">
                                        <div class="job-title-section">
                                            <h4>{{ $job->title }}</h4>
                                            <span class="job-id">ID: #{{ $job->id }}</span>
                                        </div>
                                        <div class="job-status-actions">
                                            <span class="job-status status-{{ strtolower($job->status) }}">
                                                {{ $job->status }}
                                                @if($job->status == 'Published')
                                                    <i class="fas fa-check-circle"></i>
                                                @elseif($job->status == 'Draft')
                                                    <i class="fas fa-pen"></i>
                                                @elseif($job->status == 'Closed')
                                                    <i class="fas fa-lock"></i>
                                                @endif
                                            </span>
                                            <div class="action-buttons">
                                                <button class="btn-icon" onclick="toggleJobMenu({{ $job->id }})">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="job-action-menu" id="jobMenu-{{ $job->id }}">
                                                    <a href="{{ route('employer.jobs.edit', $job->id) }}" class="menu-item">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    {{-- <a href="{{ route('employer.jobs.applications', $job->id) }}" class="menu-item">
                                                        <i class="fas fa-users"></i> View Applications
                                                    </a> --}}
                                                    @if($job->status == 'Published')
                                                        <button class="menu-item" onclick="closeJob({{ $job->id }})">
                                                            <i class="fas fa-lock"></i> Close Job
                                                        </button>
                                                    @elseif($job->status == 'Draft')
                                                        <button class="menu-item" onclick="publishJob({{ $job->id }})">
                                                            <i class="fas fa-rocket"></i> Publish
                                                        </button>
                                                    @elseif($job->status == 'Closed')
                                                        <button class="menu-item" onclick="reopenJob({{ $job->id }})">
                                                            <i class="fas fa-redo"></i> Reopen
                                                        </button>
                                                    @endif
                                                    <hr class="menu-divider">
                                                    <button class="menu-item text-danger" onclick="deleteJob({{ $job->id }})">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="job-card-body">
                                        <div class="job-meta-grid">
                                            <div class="meta-item">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span>{{ $job->location }}</span>
                                            </div>
                                            <div class="meta-item">
                                                <i class="fas fa-clock"></i>
                                                <span>{{ $job->employment_type }}</span>
                                            </div>
                                            <div class="meta-item">
                                                <i class="fas fa-tag"></i>
                                                <span>{{ $job->department ?? 'General' }}</span>
                                            </div>
                                            <div class="meta-item">
                                                <i class="fas fa-dollar-sign"></i>
                                                <span>{{ $job->salary_range ?? 'Not specified' }}</span>
                                            </div>
                                            <div class="meta-item">
                                                <i class="fas fa-calendar"></i>
                                                <span>Posted: {{ $job->created_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>

                                        <div class="job-stats-row">
                                            <div class="stat-badge">
                                                <span class="badge-count">{{ $job->applications_count ?? 0 }}</span>
                                                <span class="badge-label">Applications</span>
                                            </div>
                                            <div class="stat-badge">
                                                <span class="badge-count">{{ $job->views_count ?? 0 }}</span>
                                                <span class="badge-label">Views</span>
                                            </div>
                                            <div class="progress-indicator">
                                                <span>Filling progress</span>
                                                <div class="progress">
                                                    <div class="progress-bar" style="width: 0%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="job-card-footer">
                                        <div class="quick-actions">
                                            {{-- <a href="{{ route('employer.jobs.applications', $job->id) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye"></i> View Applications
                                            </a> --}}
                                            <button class="btn btn-outline-secondary btn-sm" onclick="shareJob({{ $job->id }})">
                                                <i class="fas fa-share"></i> Share
                                            </button>
                                        </div>
                                        <span class="last-updated">
                                            <i class="fas fa-clock"></i> Updated {{ $job->updated_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Pagination -->
                            <div class="pagination-wrapper">
                                {{ $jobs->links() }}
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <h3>No job postings yet</h3>
                                <p>Get started by creating your first job posting and attract top talent.</p>
                                <a href="{{ route('employer.post-job') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Post Your First Job
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Share Job Modal -->
    <div class="modal fade" id="shareJobModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Share Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Share this job link with candidates:</p>
                    <div class="input-group">
                        <input type="text" class="form-control" id="jobShareLink" readonly>
                        <button class="btn btn-primary" id="copyShareLinkBtn">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteJobModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this job? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete Job</button>
                </div>
            </div>
        </div>
    </div>

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

@section('scripts')
<script>
$(document).ready(function() {
    // Filter jobs by status
    $('#statusFilter').on('change', function() {
        filterJobs();
    });

    // Search jobs
    $('#jobSearch').on('input', debounce(function() {
        filterJobs();
    }, 300));

    function filterJobs() {
        const status = $('#statusFilter').val();
        const search = $('#jobSearch').val().toLowerCase();

        $('.job-management-card').each(function() {
            const $card = $(this);
            const jobStatus = $card.find('.job-status').text().trim();
            const jobTitle = $card.find('h4').text().toLowerCase();
            const jobLocation = $card.find('.meta-item:first span').text().toLowerCase();
            
            let statusMatch = status === 'all' || jobStatus === status;
            let searchMatch = search === '' || jobTitle.includes(search) || jobLocation.includes(search);
            
            $card.toggle(statusMatch && searchMatch);
        });
    }

    // Click outside to close menus
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.action-buttons').length) {
            $('.job-action-menu').removeClass('show');
        }
    });

    $('#copyShareLinkBtn').on('click', function() {
        const shareLink = $('#jobShareLink');
        shareLink.select();
        document.execCommand('copy');
        showToast('Link copied to clipboard');
    });
});

// Debounce helper
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Toggle job action menu
function toggleJobMenu(jobId) {
    $('.job-action-menu').not('#jobMenu-' + jobId).removeClass('show');
    $('#jobMenu-' + jobId).toggleClass('show');
}

// Job actions
function closeJob(jobId) {
    if (confirm('Close this job posting? This will hide it from search results.')) {
        $.ajax({
            url: `/employer/jobs/${jobId}/close`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                showToast(response.message);
                setTimeout(() => location.reload(), 1500);
            },
            error: function() {
                showToast('Failed to close job', 'error');
            }
        });
    }
}

function reopenJob(jobId) {
    $.ajax({
        url: `/employer/jobs/${jobId}/reopen`,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            showToast(response.message);
            setTimeout(() => location.reload(), 1500);
        },
        error: function() {
            showToast('Failed to reopen job', 'error');
        }
    });
}

function publishJob(jobId) {
    $.ajax({
        url: `/employer/jobs/${jobId}/publish`,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            showToast(response.message);
            setTimeout(() => location.reload(), 1500);
        },
        error: function() {
            showToast('Failed to publish job', 'error');
        }
    });
}

let currentDeleteJobId = null;

function deleteJob(jobId) {
    currentDeleteJobId = jobId;
    $('#deleteJobModal').modal('show');
}

$('#confirmDeleteBtn').on('click', function() {
    if (currentDeleteJobId) {
        $.ajax({
            url: `/employer/jobs/${currentDeleteJobId}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#deleteJobModal').modal('hide');
                showToast(response.message);
                $(`[data-job-id="${currentDeleteJobId}"]`).fadeOut(300, function() {
                    $(this).remove();
                    if ($('.job-management-card:visible').length === 0) {
                        location.reload(); 
                    }
                });
            },
            error: function() {
                showToast('Failed to delete job', 'error');
            }
        });
    }
});

function shareJob(jobId) {
    const shareUrl = `${window.location.origin}/jobs/${jobId}`;
    $('#jobShareLink').val(shareUrl);
    $('#shareJobModal').modal('show');
}

// Toast notification
const showToast = (message, type = 'success') => {
    const $toast = $('#liveToast');
    $toast.removeClass('bg-success bg-danger').addClass(`bg-${type === 'success' ? 'success' : 'danger'}`);
    $toast.find('.toast-body').text(message);
    const toast = new bootstrap.Toast($toast[0]);
    toast.show();
};
</script>
@endsection
