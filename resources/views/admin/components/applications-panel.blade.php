<div class="panel" style="padding-bottom: 1.2rem;">
    <div class="panel-header">
        <h3>Applications last 7d</h3>
        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-ellipsis-h"></i></a>
    </div>

    <div class="chart-container">
        <div class="chart-bars">
            @foreach ($applicationSeries as $point)
                <div class="bar-item">
                    <div class="bar">
                        <div class="bar fill" style="height: {{ max(8, (int) $point['height']) }}px;"></div>
                    </div>
                    <span class="bar-label">{{ $point['label'] }}</span>
                </div>
            @endforeach
        </div>

        <div class="legend">
            <span><i class="fas fa-circle" style="color:#2e5fd7;"></i> applied</span>
            <span>
                @if ($applicationsGrowthPercent >= 0)
                    +{{ $applicationsGrowthPercent }}%
                @else
                    {{ $applicationsGrowthPercent }}%
                @endif
                vs previous 30d
            </span>
        </div>
    </div>

    <div style="margin-top: 1.6rem;">
        <div class="panel-header" style="margin-bottom:0.6rem;">
            <h3 style="font-size:1.1rem;">Recent applicants</h3>
        </div>
        <div class="recent-applicants">
            @forelse ($recentApplicants as $application)
                @php
                    $fullName = trim(($application->user->first_name ?? '') . ' ' . ($application->user->last_name ?? ''));
                    $fullName = $fullName !== '' ? $fullName : ($application->user->email ?? 'Candidate');
                    $initials = collect(explode(' ', $fullName))->filter()->map(fn($part) => strtoupper(substr($part, 0, 1)))->take(2)->implode('');
                    $skillsRaw = optional($application->user->candidateProfile)->skills;
                    $skillsList = is_array($skillsRaw)
                        ? $skillsRaw
                        : (is_string($skillsRaw) ? explode(',', $skillsRaw) : []);
                    $primarySkill = collect($skillsList)
                        ->map(fn($skill) => is_string($skill) ? trim($skill) : '')
                        ->filter()
                        ->first();
                @endphp

                <div class="applicant-row">
                    <div class="applicant-info">
                        <div class="avatar">{{ $initials !== '' ? $initials : 'NA' }}</div>
                        <div class="applicant-details">
                            <h4>{{ $fullName }}</h4>
                            <p>{{ $application->job->title ?? 'Unknown role' }}{{ $application->created_at ? ' · ' . $application->created_at->diffForHumans() : '' }}</p>
                        </div>
                    </div>
                    <div class="badge">{{ $primarySkill ?: ucfirst(strtolower($application->status)) }}</div>
                </div>
            @empty
                <div class="applicant-row">
                    <div class="applicant-details">
                        <h4>No applications yet</h4>
                        <p>Applicant activity will appear here.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
