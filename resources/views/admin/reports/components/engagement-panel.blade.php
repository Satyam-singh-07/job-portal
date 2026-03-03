<div class="panel">
    <div class="panel-header">
        <h3>Engagement Diagnostics</h3>
        <a href="{{ route('admin.reports.export', ['preset' => $filters['preset'], 'start_date' => $filters['start_date'], 'end_date' => $filters['end_date']]) }}">Download metrics</a>
    </div>

    <div class="activity-list">
        <div class="activity-row">
            <div class="activity-name">Job views</div>
            <div class="activity-meta">{{ number_format((int) $engagement['job_views']) }}</div>
            <div class="activity-meta">Top of funnel</div>
        </div>
        <div class="activity-row">
            <div class="activity-name">Resume views</div>
            <div class="activity-meta">{{ number_format((int) $engagement['resume_views']) }}</div>
            <div class="activity-meta">{{ $engagement['resume_view_percent'] }}% of applications</div>
        </div>
        <div class="activity-row">
            <div class="activity-name">Messages sent</div>
            <div class="activity-meta">{{ number_format((int) $engagement['messages']) }}</div>
            <div class="activity-meta">Candidate-employer communication</div>
        </div>
        <div class="activity-row">
            <div class="activity-name">New followings</div>
            <div class="activity-meta">{{ number_format((int) $engagement['followings']) }}</div>
            <div class="activity-meta">Employer interest signal</div>
        </div>
        <div class="activity-row">
            <div class="activity-name">Apply conversion</div>
            <div class="activity-meta">{{ $engagement['application_to_job_view_percent'] }}%</div>
            <div class="activity-meta">Applications / job views</div>
        </div>
    </div>

    <hr>
    <div class="muted">
        Window: {{ $periodStart->format('M d, Y') }} - {{ $periodEnd->format('M d, Y') }}
    </div>
</div>
