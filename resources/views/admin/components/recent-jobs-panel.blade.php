<div class="panel">
    <div class="panel-header">
        <h3>Recent job posts</h3>
        <a href="{{ route('jobs.index') }}">View all <i class="fas fa-arrow-right"></i></a>
    </div>

    <div class="job-list">
        @forelse ($recentJobs as $job)
            <div class="job-item">
                <div class="job-info">
                    <div class="job-icon"><i class="fas fa-briefcase"></i></div>
                    <div class="job-details">
                        <h4>{{ $job->title }}</h4>
                        <div class="job-meta">
                            <span>{{ ucfirst(strtolower($job->status)) }}</span>
                            {{ $job->location ?? 'Location not set' }}
                            {{ $job->created_at?->diffForHumans() }}
                        </div>
                    </div>
                </div>
                <div class="job-status {{ strtolower($job->status) === 'closed' ? 'closed' : '' }}">
                    {{ (int) $job->applications_count }} apps
                </div>
            </div>
        @empty
            <div class="job-item">
                <div class="job-details">
                    <h4>No jobs yet</h4>
                    <div class="job-meta">Start by creating the first job posting.</div>
                </div>
            </div>
        @endforelse
    </div>

    <hr>
    <div style="display: flex; gap: 1.2rem; font-size:0.9rem; color:#37528b">
        <i class="fas fa-hourglass-half"></i>
        {{ number_format($stats['jobs_draft'] ?? 0) }} jobs pending review
    </div>
</div>
