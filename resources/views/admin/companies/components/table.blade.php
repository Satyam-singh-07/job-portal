<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>Company</th>
                <th>Industry</th>
                <th>Jobs</th>
                <th>Applicants</th>
                <th>Balance</th>
                <th>Rating</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($companies as $company)
            @php
                $companyName = $company->company_name ?: $company->email;
                $statusClass = strtolower($company->account_status ?? 'active');
            @endphp
            <tr>
                <td>
                    <div style="font-weight:700;">{{ $companyName }}</div>
                    <div class="muted">{{ $company->email }} | {{ $company->username ?: '-' }}</div>
                </td>
                <td>{{ $company->industry ?: '-' }}</td>
                <td>
                    <div>{{ number_format((int) $company->published_jobs_count) }} published</div>
                    <div class="muted">{{ number_format((int) $company->jobs_count) }} total</div>
                </td>
                <td>{{ number_format((int) ($company->applications_count ?? 0)) }}</td>
                <td>
                    <span class="pill {{ (int) ($company->job_posting_balance ?? 0) <= 2 ? 'closed' : 'published' }}">
                        {{ (int) ($company->job_posting_balance ?? 0) }} credits
                    </span>
                </td>
                <td>{{ number_format((float) ($company->rating ?? 0), 2) }}</td>
                <td>
                    <span class="pill {{ $statusClass === 'suspended' ? 'closed' : 'published' }}">
                        {{ $company->account_status ?? 'Active' }}
                    </span>
                </td>
                <td>
                    <div class="inline-actions">
                        <a href="{{ route('admin.companies.show', $company) }}" class="btn">View</a>

                        @if (($company->account_status ?? 'Active') === 'Suspended')
                            <form method="POST" action="{{ route('admin.companies.status', $company) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="account_status" value="Active">
                                <button type="submit" class="btn">Activate</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.companies.status', $company) }}" onsubmit="return confirm('Suspend this company account?');">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="account_status" value="Suspended">
                                <button type="submit" class="btn danger">Suspend</button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('admin.companies.posting-balance', $company) }}" class="inline-actions" style="align-items:center;">
                            @csrf
                            @method('PATCH')
                            <select name="balance_action" class="select" style="max-width:110px;">
                                <option value="add">Add</option>
                                <option value="subtract">Subtract</option>
                                <option value="set">Set</option>
                            </select>
                            <input type="number" name="amount" min="0" max="100000" class="input" style="max-width:100px;" value="1" required>
                            <button type="submit" class="btn">Update Credits</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="muted" style="padding:1rem;">No companies found for current filters.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="pagination-wrap">
    {{ $companies->links() }}
</div>
