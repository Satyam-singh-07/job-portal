<!DOCTYPE html>
<html lang="en">
@include('admin.components.styles')
<body>
    <div class="dashboard">
        @include('admin.components.sidebar', ['stats' => $stats])

        <main class="main">
            <div class="toolbar">
                <div class="page-title">
                    <h1>{{ $job->title }}</h1>
                    <p>{{ $job->department ?: 'General' }} | {{ $job->location }} | {{ $job->employment_type }}</p>
                </div>
                <a href="{{ route('admin.jobs.index') }}" class="btn">Back to jobs</a>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <h3>Job control</h3>
                    <span class="pill {{ strtolower($job->status) }}">{{ $job->status }}</span>
                </div>

                <div class="inline-actions" style="margin-bottom: 1rem;">
                    <form method="POST" action="{{ route('admin.jobs.status', $job) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Published">
                        <button class="btn" type="submit">Publish</button>
                    </form>
                    <form method="POST" action="{{ route('admin.jobs.status', $job) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Closed">
                        <button class="btn" type="submit">Close</button>
                    </form>
                    <form method="POST" action="{{ route('admin.jobs.status', $job) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Draft">
                        <button class="btn" type="submit">Move to draft</button>
                    </form>
                    <form method="POST" action="{{ route('admin.jobs.destroy', $job) }}" onsubmit="return confirm('Delete this job?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn danger" type="submit">Delete</button>
                    </form>
                </div>

                <div class="activity-list">
                    <div class="activity-row">
                        <div class="activity-name">Employer</div>
                        <div class="activity-meta">{{ $job->user->company_name ?: $job->user->email }}</div>
                        <div class="activity-meta">{{ $job->user->email }}</div>
                    </div>
                    <div class="activity-row">
                        <div class="activity-name">Open roles</div>
                        <div class="activity-meta">{{ number_format((int) $job->open_roles) }}</div>
                        <div class="activity-meta">{{ $job->applications_count }} applications</div>
                    </div>
                    <div class="activity-row">
                        <div class="activity-name">Published details</div>
                        <div class="activity-meta">{{ $job->created_at?->format('M d, Y H:i') }}</div>
                        <div class="activity-meta">{{ $job->created_at?->diffForHumans() }}</div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <h3>Summary</h3>
                </div>
                <div class="muted" style="font-size: .9rem; line-height: 1.6;">{{ $job->summary }}</div>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <h3>Recent applicants</h3>
                </div>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Candidate</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Applied</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($job->applications as $application)
                            @php
                                $candidateName = trim(($application->user->first_name ?? '') . ' ' . ($application->user->last_name ?? ''));
                                $candidateName = $candidateName !== '' ? $candidateName : ($application->user->email ?? 'Candidate');
                            @endphp
                            <tr>
                                <td>{{ $candidateName }}</td>
                                <td>{{ $application->user->email ?? '-' }}</td>
                                <td><span class="pill draft">{{ $application->status }}</span></td>
                                <td>{{ $application->created_at?->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="muted" style="padding: 1rem;">No applicants yet.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
