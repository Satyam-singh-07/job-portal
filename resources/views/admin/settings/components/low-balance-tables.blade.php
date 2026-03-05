<div class="insight-panels">
    <div class="panel">
        <div class="panel-header">
            <h3>Low Candidate Application Balance</h3>
            <a href="{{ route('admin.candidates.index') }}">Open candidates</a>
        </div>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Candidate</th>
                        <th>Email</th>
                        <th>Applications</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($lowBalanceCandidates as $candidate)
                    @php
                        $name = trim(($candidate->first_name ?? '') . ' ' . ($candidate->last_name ?? ''));
                        $name = $name !== '' ? $name : $candidate->email;
                    @endphp
                    <tr>
                        <td>{{ $name }}</td>
                        <td>{{ $candidate->email }}</td>
                        <td>{{ number_format((int) $candidate->applications_count) }}</td>
                        <td><span class="pill closed">{{ (int) $candidate->job_application_balance }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="muted" style="padding:1rem;">No candidate accounts are low on credits.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3>Low Employer Posting Balance</h3>
            <a href="{{ route('admin.companies.index') }}">Open companies</a>
        </div>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Email</th>
                        <th>Published</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($lowBalanceEmployers as $company)
                    <tr>
                        <td>{{ $company->company_name ?: 'Company' }}</td>
                        <td>{{ $company->email }}</td>
                        <td>{{ number_format((int) $company->published_jobs_count) }}</td>
                        <td><span class="pill closed">{{ (int) $company->job_posting_balance }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="muted" style="padding:1rem;">No employer accounts are low on posting credits.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
