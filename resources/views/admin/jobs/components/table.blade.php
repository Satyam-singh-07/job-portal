<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>Job</th>
                <th>Employer</th>
                <th>Status</th>
                <th>Applications</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($jobs as $job)
            @php
                $statusClass = strtolower($job->status);
                $employerName = $job->user->company_name ?: $job->user->email;
            @endphp
            <tr>
                <td>
                    <div style="font-weight: 700;">{{ $job->title }}</div>
                    <div class="muted">{{ $job->department ?: 'General' }} | {{ $job->location }} | {{ $job->employment_type }}</div>
                </td>
                <td>
                    <div>{{ $employerName }}</div>
                    <div class="muted">{{ $job->user->email }}</div>
                </td>
                <td><span class="pill {{ $statusClass }}">{{ $job->status }}</span></td>
                <td>{{ number_format((int) $job->applications_count) }}</td>
                <td>
                    <div>{{ $job->created_at?->format('M d, Y') }}</div>
                    <div class="muted">{{ $job->created_at?->diffForHumans() }}</div>
                </td>
                <td>
                    <div class="inline-actions">
                        <a href="{{ route('admin.jobs.show', $job) }}" class="btn">View</a>

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
                            <button class="btn" type="submit">Draft</button>
                        </form>

                        <form method="POST" action="{{ route('admin.jobs.destroy', $job) }}" onsubmit="return confirm('Delete this job?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn danger" type="submit">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="muted" style="padding: 1rem;">No jobs found with current filters.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="pagination-wrap">
    {{ $jobs->links() }}
</div>
