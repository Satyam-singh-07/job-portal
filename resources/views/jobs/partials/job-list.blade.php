<div class="job-list">
    @forelse($jobs as $job)
        <div class="job-list-item {{ $job->is_featured ? 'featured' : '' }}">
            <div class="job-card-status">
                <span class="job-type {{ strtolower(str_replace(' ', '', $job->employment_type)) }}">
                    {{ $job->employment_type }}
                </span>
            </div>
            <div class="job-list-main">
                <div class="job-list-logo">
                    <img src="{{ $job->user->logo_url }}" alt="{{ $job->user->company_name }}" />
                </div>
                <div class="job-list-content">
                    <h4><a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a></h4>
                    <div class="job-list-meta">
                        <span><i class="fa fa-briefcase" aria-hidden="true"></i>
                            {{ $job->user->company_name }}</span>
                        <span><i class="fa fa-map-marker" aria-hidden="true"></i>
                            {{ $job->location }}</span>
                        <span><i class="fa fa-money" aria-hidden="true"></i> 
                            {{ $job->salary_range ?? 'Not specified' }}</span>
                    </div>
                    <p class="job-list-summary">
                        {{ Str::limit($job->summary, 150) }}
                    </p>
                </div>
                <div class="job-list-actions">
                    <a href="{{ route('jobs.show', $job->slug) }}" class="btn btn-outline-primary btn-sm">View Details</a>
                    <button
                        type="button"
                        class="bookmark js-save-job {{ !empty($job->is_favorited) ? 'active' : '' }}"
                        aria-label="{{ !empty($job->is_favorited) ? 'Remove saved job' : 'Save job' }}"
                        data-is-favorited="{{ !empty($job->is_favorited) ? '1' : '0' }}"
                        data-save-url="{{ route('candidate.jobs.favourite', $job->id) }}"
                        data-remove-url="{{ route('candidate.favourites.destroy', $job->id) }}"
                    >
                        <i class="{{ !empty($job->is_favorited) ? 'fa-solid' : 'fa-regular' }} fa-bookmark" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="job-list-footer d-flex justify-content-between align-items-center flex-wrap">
                <span class="job-list-posted">Posted {{ $job->created_at->format('M d, Y') }}</span>
                <span class="job-list-posted">ID: JP-{{ $job->id }}</span>
            </div>
        </div>
    @empty
        <div class="empty-state text-center py-5">
            <i class="fa fa-search fa-3x mb-3 text-muted"></i>
            <h3>No Jobs Found</h3>
            <p>We couldn't find any jobs matching your criteria. Try adjusting your filters.</p>
        </div>
    @endforelse
</div>

@if($jobs->hasPages())
    <div class="jobs-pagination mt-4">
        {{ $jobs->links('pagination::bootstrap-5') }}
    </div>
@endif
