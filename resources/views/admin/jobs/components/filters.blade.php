<form class="filters-form" method="GET" action="{{ route('admin.jobs.index') }}">
    <input class="input" type="text" name="search" value="{{ $filters['search'] }}" placeholder="Search title, location, department, employer">

    <select class="select" name="status">
        <option value="">All status</option>
        @foreach (['Draft', 'Published', 'Closed'] as $status)
            <option value="{{ $status }}" @selected($filters['status'] === $status)>{{ $status }}</option>
        @endforeach
    </select>

    <select class="select" name="employment_type">
        <option value="">All types</option>
        @foreach ($employmentTypes as $type)
            <option value="{{ $type }}" @selected($filters['employment_type'] === $type)>{{ $type }}</option>
        @endforeach
    </select>

    <select class="select" name="employer_id">
        <option value="">All employers</option>
        @foreach ($employers as $employer)
            @php $employerLabel = $employer->company_name ?: $employer->email; @endphp
            <option value="{{ $employer->id }}" @selected($filters['employer_id'] === (string) $employer->id)>{{ $employerLabel }}</option>
        @endforeach
    </select>

    <select class="select" name="sort">
        <option value="latest" @selected($filters['sort'] === 'latest')>Newest first</option>
        <option value="oldest" @selected($filters['sort'] === 'oldest')>Oldest first</option>
        <option value="applications" @selected($filters['sort'] === 'applications')>Most applications</option>
        <option value="title_asc" @selected($filters['sort'] === 'title_asc')>Title A-Z</option>
        <option value="title_desc" @selected($filters['sort'] === 'title_desc')>Title Z-A</option>
    </select>

    <div class="inline-actions">
        <button type="submit" class="btn primary">Apply</button>
        <a href="{{ route('admin.jobs.index') }}" class="btn">Reset</a>
    </div>
</form>
