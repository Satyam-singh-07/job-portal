<!DOCTYPE html>
<html lang="en">
@include('admin.components.styles')
<body>
    <div class="dashboard">
        @include('admin.components.sidebar', ['stats' => $stats])

        <main class="main">
            <div class="toolbar">
                <div class="page-title">
                    <h1>{{ $company->company_name ?: $company->email }}</h1>
                    <p>{{ $company->industry ?: 'Industry not specified' }} | {{ $company->email }}</p>
                </div>
                <a class="btn" href="{{ route('admin.companies.index') }}">Back to companies</a>
            </div>

            <div class="insight-panels">
                <div class="panel">
                    <div class="panel-header">
                        <h3>Account controls</h3>
                        <span class="pill {{ ($company->account_status ?? 'Active') === 'Suspended' ? 'closed' : 'published' }}">{{ $company->account_status ?? 'Active' }}</span>
                    </div>

                    <div class="activity-list">
                        <div class="activity-row">
                            <div class="activity-name">Username</div>
                            <div class="activity-meta">{{ $company->username ?: '-' }}</div>
                            <div class="activity-meta">Joined {{ $company->created_at?->diffForHumans() }}</div>
                        </div>
                        <div class="activity-row">
                            <div class="activity-name">Published jobs</div>
                            <div class="activity-meta">{{ number_format((int) $company->published_jobs_count) }}</div>
                            <div class="activity-meta">{{ number_format((int) $company->jobs_count) }} total jobs</div>
                        </div>
                        <div class="activity-row">
                            <div class="activity-name">Applications</div>
                            <div class="activity-meta">{{ number_format((int) $applicationsTotal) }}</div>
                            <div class="activity-meta">{{ number_format((int) $company->followers_count) }} followers</div>
                        </div>
                        <div class="activity-row">
                            <div class="activity-name">Posting credits</div>
                            <div class="activity-meta">{{ number_format((int) ($company->job_posting_balance ?? 0)) }}</div>
                            <div class="activity-meta">Remaining employer balance</div>
                        </div>
                    </div>

                    <hr>

                    <div class="inline-actions" style="margin-bottom: .8rem;">
                        @if (($company->account_status ?? 'Active') === 'Suspended')
                            <form method="POST" action="{{ route('admin.companies.status', $company) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="account_status" value="Active">
                                <button class="btn" type="submit">Activate account</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.companies.status', $company) }}" onsubmit="return confirm('Suspend this company account?');">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="account_status" value="Suspended">
                                <button class="btn danger" type="submit">Suspend account</button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('admin.companies.rating', $company) }}" class="inline-actions" style="align-items:center;">
                            @csrf
                            @method('PATCH')
                            <input type="number" step="0.1" min="0" max="5" name="rating" class="input" value="{{ number_format((float) ($company->rating ?? 0), 1, '.', '') }}" style="max-width: 110px;">
                            <button class="btn" type="submit">Update rating</button>
                        </form>

                        <form method="POST" action="{{ route('admin.companies.posting-balance', $company) }}" class="inline-actions" style="align-items:center;">
                            @csrf
                            @method('PATCH')
                            <select name="balance_action" class="select" style="max-width:110px;">
                                <option value="add">Add</option>
                                <option value="subtract">Subtract</option>
                                <option value="set">Set</option>
                            </select>
                            <input type="number" min="0" max="100000" name="amount" class="input" value="1" style="max-width:100px;" required>
                            <button class="btn" type="submit">Update credits</button>
                        </form>
                    </div>

                    <div class="muted" style="line-height:1.6;">
                        <strong>Website:</strong>
                        @if($company->website)
                            <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer">{{ $company->website }}</a>
                        @else
                            -
                        @endif
                        <br>
                        <strong>Tagline:</strong> {{ $company->tagline ?: '-' }}
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-header">
                        <h3>Recent jobs</h3>
                    </div>
                    <div class="activity-list">
                        @forelse ($recentJobs as $job)
                            <div class="activity-row">
                                <div>
                                    <div class="activity-name">{{ $job->title }}</div>
                                    <div class="activity-meta">{{ $job->location }} | {{ $job->employment_type }}</div>
                                </div>
                                <div class="activity-meta">{{ (int) $job->applications_count }} apps</div>
                                <div class="activity-meta">{{ $job->created_at?->diffForHumans() }}</div>
                            </div>
                        @empty
                            <div class="activity-row"><div class="activity-meta">No jobs posted yet.</div></div>
                        @endforelse
                    </div>
                </div>
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
                                <th>Job</th>
                                <th>Status</th>
                                <th>Applied</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($recentApplications as $application)
                            @php
                                $candidateName = trim(($application->user->first_name ?? '').' '.($application->user->last_name ?? ''));
                                $candidateName = $candidateName !== '' ? $candidateName : ($application->user->email ?? 'Candidate');
                            @endphp
                            <tr>
                                <td>{{ $candidateName }}</td>
                                <td>{{ $application->user->email ?? '-' }}</td>
                                <td>{{ $application->job->title ?? '-' }}</td>
                                <td><span class="pill draft">{{ $application->status }}</span></td>
                                <td>{{ $application->created_at?->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="muted" style="padding:1rem;">No applications yet.</td>
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
